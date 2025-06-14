<?php
    namespace App\Http\Controllers\KelolaPretestPostest;
    use App\Http\Controllers\Controller;
    use App\Models\NilaiPrePostTest;

class NilaiPrePostTestController extends Controller
{
    public function index()
    {
        return NilaiPrePostTest::all();
    }
}
