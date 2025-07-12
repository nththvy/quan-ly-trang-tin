<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            if ($subscriber->is_active) {
                // Nếu email đã đăng ký và active = true
                // Gửi email thông báo người dùng đã đăng ký thành công và kèm link hủy đăng ký
                $unsubscribeLink = route('frontend.subscriber.unsubscribe', $subscriber->token);

                // Gửi email thông báo người dùng đã đăng ký rồi
                Mail::send('email.new_article', [
                    'confirmLink' => null, // Không cần gửi lại link xác nhận
                    'unsubscribeLink' => $unsubscribeLink
                ], function ($message) use ($subscriber) {
                    $message->to($subscriber->email)
                        ->subject('Bạn đã đăng ký nhận tin');
                });

                return back()->with('info', 'Bạn đã đăng ký nhận tin rồi. Kiểm tra email của bạn để hủy đăng ký nếu cần.');
            }

            // Nếu email đã đăng ký nhưng đã hủy, sẽ kích hoạt lại và tạo token mới
            $subscriber->update([
                'is_active' => true,
                'token' => Str::uuid(), // Tạo token mới để bảo mật
            ]);
        } else {
            // Tạo mới nếu email chưa tồn tại trong cơ sở dữ liệu
            $subscriber = Subscriber::create([
                'email' => $email,
                'token' => Str::uuid(),
            ]);
        }

        // Liên kết xác nhận đăng ký và hủy đăng ký
        $confirmLink = route('frontend.subscriber.subscribe', $subscriber->token);
        $unsubscribeLink = route('frontend.subscriber.unsubscribe', $subscriber->token);

        // Gửi email xác nhận kèm liên kết xác nhận đăng ký và hủy đăng ký
        Mail::send('email.new_article', [
            'confirmLink' => $confirmLink,
            'unsubscribeLink' => $unsubscribeLink
        ], function ($message) use ($subscriber) {
            $message->to($subscriber->email)
                ->subject('Đăng ký nhận tin thành công');
        });

        return back()->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email của bạn.');
    }

    public function unsubscribe($token)
    {
        $subscriber = Subscriber::where('token', $token)->first();

        if (!$subscriber) {
            return redirect('/')->with('error', 'Liên kết không hợp lệ.');
        }

        $subscriber->update(['is_active' => false]);

        return redirect('/')->with('success', 'Bạn đã hủy đăng ký thành công.');
    }

    public function getList()
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.subscribers.list', compact('subscribers'));
    }

    public function getDelete($id)
    {
        $subscriber = Subscriber::find($id);
        if ($subscriber) {
            $subscriber->delete();
        }

        return redirect()->route('admin.subscribers')->with('success', 'Xóa người đăng ký thành công');
    }
}
