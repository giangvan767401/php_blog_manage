<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function writerRequests()
    {
        if (auth()->user()->role !== User::ROLE_ADMIN) {
            abort(403);
        }

        $users = User::where('writer_status', User::WRITER_STATUS_PENDING)
            ->latest()
            ->paginate(15);

        return view('admin.users.writer_requests', compact('users'));
    }

    public function approveWriter($id)
    {
        if (auth()->user()->role !== User::ROLE_ADMIN) {
            abort(403);
        }

        $user = User::findOrFail($id);
        $user->update([
            'role' => User::ROLE_WRITER,
            'writer_status' => User::WRITER_STATUS_APPROVED
        ]);

        return redirect()->back()->with('success', "Đã cấp quyền Writer cho {$user->name}");
    }

    public function rejectWriter($id)
    {
        if (auth()->user()->role !== User::ROLE_ADMIN) {
            abort(403);
        }

        $user = User::findOrFail($id);
        $user->update([
            'writer_status' => User::WRITER_STATUS_REJECTED
        ]);

        return redirect()->back()->with('success', "Đã từ chối yêu cầu của {$user->name}");
    }

    public function requestWriter()
    {
        $user = auth()->user();
        
        if (!$user->canRequestWriter()) {
            return redirect()->back()->with('error', 'Bạn không thể thực hiện yêu cầu này.');
        }

        $user->update([
            'writer_status' => User::WRITER_STATUS_PENDING
        ]);

        return redirect()->back()->with('success', 'Yêu cầu của bạn đã được gửi và đang chờ duyệt.');
    }
}
