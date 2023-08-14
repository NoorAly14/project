<?php

namespace App\Http\Controllers\Backend;


use DateTime;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function ReportView(){

        return view('backend.report.report_view');

    }



    
    public function SearchByData(Request $request){

        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $orders = Order::where('order_date',$formatDate)->latest()->get();
        return view('backend.report.report_by_data',compact('orders','formatDate'));

    }

    public function SearchByMonth(Request $request){

        
        $month = $request->month;
        $year = $request->year_name;
        
        $orders = Order::where('order_month',$month)->where('order_year',$year)->latest()->get();
        return view('backend.report.report_by_month',compact('orders','month','year'));

        
    }

    public function SearchByYear(Request $request){

        $year = $request->year;

        $orders = Order::where('order_year',$year)->latest()->get();
        return view('backend.report.report_by_year',compact('orders','year'));


    }

    public  function OrderByUser(){

        $users = User::where('role','user')->latest()->get();
        return view('backend.report.report_by_user',compact('users'));
    }

    public function SearchByUser(Request $request){

        $users = $request->user;
        $orders = Order::where('user_id',$users)->latest()->get();
        return view('backend.report.report_by_user_show',compact('orders','users'));



    }

}
