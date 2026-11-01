<?php declare(strict_types=1);

namespace Framework\Controllers;

use Framework\Http\Request;
use Framework\Http\Response;

final class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        return $this->view('home');
    }
}
