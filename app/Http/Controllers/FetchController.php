<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class FetchController extends Controller
{
    public function __invoke(Request $request, int $count): Response
    {
        Artisan::call("app:print-entry-comment-from-google-sheet --count={$count} --web");
        $output = Artisan::output();

        return response($output)
            ->header('Content-Type', 'text/plain');
    }
}
