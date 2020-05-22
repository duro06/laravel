<?php
namespace App\Repositories;

use App\Members;
use App\User;

use Illuminate\Support\Facades\DB;

class MemberRepo {

    public function getAllMembers($q, $ss){
        if($q!=null){
            $member = Members::orderBy(request()->sortby, request()->sortbydesc)
                ->when(request()->q, function($member) {
                    $member = $member->where('name', 'LIKE', '%' . request()->q . '%');
                })->paginate(request()->per_page);

        }else{
            $member = Members::orderBy(request()->sortby, request()->sortbydesc)
                ->when(request()->ss, function($member) {
                    $member = $member->where('status', 'LIKE', '%' . request()->ss . '%');
                })->paginate(request()->per_page);

        }
        return $member;
    }
}