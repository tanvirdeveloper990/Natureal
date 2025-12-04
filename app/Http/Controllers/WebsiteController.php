<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\AboutUS;
use App\Models\Affiliate;
use App\Models\Bannar;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Client;
use App\Models\CommissionLevel;
use App\Models\CommonSection;
use App\Models\Coupon;
use App\Models\CustomerContact;
use App\Models\CustomerReview;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerCommission;
use App\Models\Setting;
use App\Models\SslCommerc;
use App\Models\Team;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Contracts\Service\Attribute\Required;

class WebsiteController extends Controller
{


    public function index()
    {
        $setting = Setting::first();
        $categories = Category::with('products')->where('status', 1)->get();
        $is_new = Product::where('status', 1)->where('is_new', 1)->get();
        $is_popular = Product::where('status', 1)->where('is_popular', 1)->get();
        $is_featured = Product::where('status', 1)->where('is_featured', 1)->get();
        $banner = Bannar::first();
        $customer_reviews = CustomerReview::where('status', 1)->latest()->get();
        $blogs = Blog::where('status', 1)->latest()->get();
        $approved_certificated = CommonSection::where('status',1)->where('type','Approved & Certified')->get();
        $seller_progamer = CommonSection::where('status',1)->where('type','Seller Program')->get();
        $new_enterprenure = CommonSection::where('status',1)->where('type','New entrepreneurs')->get();
        $brands = Brand::where('status',1)->get();
        $commission_level = CommissionLevel::where('status',1)->get();
        return view('frontend.index', compact('commission_level','brands','new_enterprenure','seller_progamer','approved_certificated','customer_reviews', 'blogs', 'setting', 'categories', 'is_new', 'is_popular', 'is_featured', 'banner'));
    }

    public function about()
    {
        $data = AboutUS::first();
        $teams = Team::where('status',1)->get();
        $clients = Client::where('status',1)->get();
        return view('frontend.about',compact('data','teams','clients'));
    }
    public function sellers()
    {
        $sellers = Vendor::where('status',1)->latest()->get();
        return view('frontend.sellers',compact('sellers'));
    }
    public function shop($slug)
    {
        $sellers = Vendor::where('shop_slug',$slug)->first();
        return view('frontend.sellers-shop',compact('sellers'));
    }

    public function affiliateRegister()
    {
        return view('affiliate.register');
    }
    public function affiliateLogin()
    {
        return view('affiliate.login');
    }
    

      // Store affiliate registration
    public function storeaffiliate(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:affiliates,email',
            'phone' => 'required|string|unique:affiliates,phone',
            'username' => 'required|string|unique:affiliates,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $affiliate = Affiliate::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'website_url' => $request->website_url,
            'social_media_link' => $request->social_media_link,
            'promotion_method' => $request->promotion_method,
            'referal_name_id' => $request->referal_name_id,
            'status' => 'pending', // default
        ]);

        return redirect()->back()->with('success', 'Registration successful! Your account is pending approval.');
    }


    public function sellerRegister()
    {
        return view('frontend.seller-register');
    }
    public function sellerLogin()
    {
        return view('frontend.seller-login');
    }
    

      // Store seller registration
    public function storeSeller(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'shop_name'   => 'required|string|max:255|unique:vendors,shop_name',
            'email'       => 'required|email|unique:vendors,email',
            'phone'       => 'required|string|max:20|unique:vendors,phone',
            'password'    => 'required|min:6|confirmed',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:500',

            'logo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Generate shop slug
        $shop_slug = Str::slug($request->shop_name);

        // Ensure slug is unique
        $originalSlug = $shop_slug;
        $counter = 1;
        while (Vendor::where('shop_slug', $shop_slug)->exists()) {
            $shop_slug = $originalSlug . '-' . $counter++;
        }

        // Upload images using ImageHelper
        $logo = $request->hasFile('logo')
            ? ImageHelper::uploadImage($request->file('logo'))
            : null;

        $banner = $request->hasFile('banner')
            ? ImageHelper::uploadImage($request->file('banner'))
            : null;

        // Save seller
        Vendor::create([
            'name'        => $request->name,
            'shop_name'   => $request->shop_name,
            'shop_slug'   => $shop_slug,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'password'    => Hash::make($request->password),
            'address'     => $request->address,
            'city'        => $request->city,
            'country'     => $request->country,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
            'logo'        => $logo,
            'banner'      => $banner,
            'status'      => 'inactive',
        ]);

        return back()->with('success', 'Seller Registration Successful! & Waiting for Approval');
    }



    public function products(Request $request)
    {
        $setting = Setting::first();

        $query = Product::where('status', 1);

        $categoryName = 'All Products'; // default title

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
            $category = Category::find($request->category);
            if ($category) {
                $categoryName = $category->name; // set category name dynamically
            }
        }

        $products = $query->latest()->get();

        return view('frontend.products', compact('setting', 'products', 'categoryName'));
    }


    public function productSingle($slug)
    {
        $item = Product::where('slug', $slug)->firstOrFail(); // not found হলে automatic 404
        $setting = Setting::first();

        $affiliate = '';
        // Related products fetch
        $relatedProducts = $item->relatedProducts();
        return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate'));
    }
    public function singleBlog($slug)
    {
        $data = Blog::where('slug', $slug)->firstOrFail(); // not found হলে automatic 404
        $setting = Setting::first();
        $products = Product::where('status', 1)->latest()->get();
        return view('frontend.blog-single', compact('data', 'setting', 'products'));
    }

    public function productSingleAffiliate($slug, $affiliate_id)
    {
        $item = Product::where('slug', $slug)->firstOrFail(); // If not found, it will automatically throw a 404
        $setting = Setting::first();

        // Retrieve the affiliate details
        $affiliate = Affiliate::findOrFail($affiliate_id);

        // Fetch related products
        $relatedProducts = $item->relatedProducts();

        // Return the view with the necessary data
        return view('frontend.product-single', compact('item', 'setting', 'relatedProducts', 'affiliate'));
    }


    public function categories($slug)
    {
        $category = Category::with('products')->where('slug', $slug)->firstOrFail(); // not found হলে automatic 404
        $setting = Setting::first();
        return view('frontend.categories', compact('category', 'setting'));
    }

    public function liveSearch(Request $request)
    {
        $query = $request->get('q');

        $products = Product::select('id', 'name', 'slug', 'regular_price', 'sale_price')
            ->where('name', 'like', "%{$query}%")
            ->limit(8)
            ->get();

        return response()->json($products);
    }

    public function validateCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_code', $request->coupon_code)
            ->where('status', 1)
            ->first();

        if ($coupon) {
            return response()->json([
                'valid' => true,
                'amount' => $coupon->amount
            ]);
        } else {
            return response()->json(['valid' => false]);
        }
    }



    public function checkout()
    {
        $ssl = SslCommerc::first();
        return view('frontend.checkout', compact('ssl'));
    }

    public function orderStore(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'delivery_area' => 'required|string',
            'payment_method' => 'required|string',
            'items' => 'required|array',
            'total' => 'required|numeric',
        ]);

        // User ID check
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            // Generate unique email and username
            $uniqueString = Str::random(6) . time();
            $guestEmail = 'guest_' . $uniqueString . '@example.com';
            $guestUsername = 'guest_' . $uniqueString;

            // Create a new guest user
            $guestUser = User::create([
                'name' => $request->customer_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $guestEmail,
                'username' => $guestUsername,
                'password' => bcrypt(Str::random(8)), // random password
            ]);

            $userId = $guestUser->id;
        }

        // Create Order
        $order = Order::create([
            'user_id' => $userId,
            'total' => $request->total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'delivery_area' => $request->delivery_area,
            'delivery_charge' => $request->delivery_charge ?? 0,
            'transaction_id' => $request->transaction_id ?? null,
            'payment_date' => now(),
            'payment_status' => 'pending',
            'coupon_code' => $request->coupon_code,
            'coupon' => $request->coupon_amount,
        ]);

        // Save order items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['productId'],
                'product_variant_id' => $item['variantId'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'affiliate_id' => $item['affiliateId'] ?? null, // Ensure affiliate_id is passed

            ]);
        }

        // Clear cart after successful order
        session()->flash('success', 'Order Created Successfully');
        // Return JSON with order ID for AJAX
        return response()->json([
            'success' => true,
            'id' => $order->order_id, // Use order_id field (not primary key)
        ]);
    }



    public function reviews()
    {
        $setting = Setting::first();
        return view('frontend.reviews', compact('setting'));
    }
    public function contacts()
    {
        $setting = Setting::first();
        return view('frontend.contacts', compact('setting'));
    }

    public function contactStore(Request $request)
    {
        $data = $request->all();
        CustomerContact::create($data);
        return redirect()->back()->with('success', 'Thank you for contacting us!');
    }



    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $imagePath = null;

        if ($socialUser->getAvatar()) {
            // Download image from URL
            $imageContents = file_get_contents($socialUser->getAvatar());

            // Generate unique filename
            $filename = 'users/' . Str::uuid() . '.jpg';

            // Store image to storage/app/public/users
            Storage::disk('public')->put($filename, $imageContents);

            $imagePath = $filename;
        }

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(24)),
                'image' => $imagePath,
            ]
        );

        // Optional: Update image if user already exists but has no image
        if (!$user->image && $imagePath) {
            $user->image = $imagePath;
            $user->save();
        }

        Auth::login($user);
        return redirect()->intended('/home');
    }


    public function showRegistrationForm($referrer_id = null)
    {
        return view('auth.register-refer', ['referrer_id' => $referrer_id]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits_between:10,14|unique:users',
            'password' => 'required|confirmed|min:6',
            'referrer_id' => 'nullable|exists:users,id',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'referrer_id' => $request->referrer_id,
        ]);

        // Log in the user
        auth()->login($user);

        // Trigger email verification event
        event(new Registered($user));

        return redirect()->route('verification.notice');
    }

    // Track Order
    // public function trackorder()
    // {
    //     return view('frontend.track-order');
    // }

    public function trackorder(Request $request)
    {
        $order = null;

        if ($request->has('invoice_id')) {
            $invoiceId = $request->invoice_id;

            $order = Order::with('orderItems.product', 'user')
                ->where('order_id', $invoiceId)
                ->first();
        }

        return view('frontend.track-order', compact('order'));
    }

    public function orderSuccess($order_id)
    {
        $data = Order::where('order_id', $order_id)->firstOrFail();
        return view('frontend.success', compact('data'));
    }
}
