<?php

namespace App\Http\View\Composers;

use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InquiryComposer
{
    /**
     * The inquiry model implementation.
     *
     * @var Inquiry;
     */
    protected $inquiries;

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $messages = DB::table('inquiries AS i')
            ->join('users AS u', 'i.created_by', '=', 'u.id');

        if (Auth::user()->type == 'Admin') {
            $messages = $messages->whereIn('i.id', function ($query) {
                $query->select(DB::raw('MAX(id)'))->from('inquiries')->groupby('student_id');
            })
            ->where('u.type', '<>', 'Admin');
        } else {
            $messages = $messages->where('i.student_id', Auth::user()->id)
                ->where('i.created_by', '<>', Auth::user()->id);
        }

        $messages = $messages->whereNull('i.is_read')->get();
        $view->with('message_count', count($messages));
    }
}
