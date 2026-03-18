<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = strtolower(trim($request->input('message')));
        $response = $this->getResponse($message);
        return response()->json([
            'success' => true,
            'response' => $response
        ]);
    }
    private function getResponse($message)
    {
        if (preg_match('/\b(hello|hi|hey)\b/i', $message)) {
            return "Hello! How can I help you today with your Athletiq gear?";
        }
        if (preg_match('/\b(order|track|tracking)\b/i', $message)) {
            return "You can track your orders in your profile section, or I can help you if you provide an Order ID.";
        }
        if (preg_match('/\b(shipping|delivery|ship)\b/i', $message)) {
            return "We offer free shipping on orders over £50! Standard delivery takes 3-5 business days.";
        }
        if (preg_match('/\b(return|refund|exchange)\b/i', $message)) {
            return "We have a 30-day hassle-free return policy. Just make sure the items are in their original condition!";
        }
        if (preg_match('/\b(size|fit|sizing|small|large|medium)\b/i', $message)) {
            return "Our gear is designed for an athletic fit. If you're between sizes, we recommend sizing up for comfort.";
        }
        if (preg_match('/\b(contact|email|support|help)\b/i', $message)) {
            return "You can reach our support team at support@athletiq.com or via our Contact page.";
        }
        return "That's a great question! I'm still learning, so for specific inquiries, you might want to check our FAQ or contact support.";
    }
}
