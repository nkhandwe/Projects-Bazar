<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductFaq;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ProductFaqController extends Controller
{
    public function index()
    {
        $productFaq = ProductFaq::paginate(10);
        return view('admin-views.product-faqs.index', compact('productFaq'));
    }

    public function store(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);

        $productFaq = new ProductFaq();

        $productFaq->question = $validated['question'];
        $productFaq->answer = $validated['answer'];

        $productFaq->save();

        Toastr::success('Product FAQ created successfully.');

        return back();
    }

    public function delete(Request $request)
    {
        $productFaq = ProductFaq::findOrFail($request->id);
        $productFaq->delete();

        Toastr::success('Product FAQ deleted successfully.');

        return back();
    }
}
