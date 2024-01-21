<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmitController extends Controller
{
    /**
     * Change the submission status of a user for an assignment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $assignmentId
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function changeSubmissionStatus(Request $request, $assignmentId, $userId)
    {
        // Optional: Add authorization logic here

        try {
            DB::transaction(function () use ($assignmentId, $userId) {
                $assignment = Assignment::findOrFail($assignmentId);
                $user = User::findOrFail($userId);

                // Check if the user is already associated with the assignment
                $submission = $assignment->students()->where('user_id', $user->id)->first();

                if ($submission) {
                    // Toggle the submission status
                    $newStatus = !$submission->pivot->submitted;
                    $assignment->students()->updateExistingPivot($user->id, ['submitted' => $newStatus]);
                } else {
                    // Handle the case where the user is not associated with the assignment
                    // This depends on your application logic
                }
            });

            return back()->with('success', 'Submission status updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating the submission status.');
        }
    }
}
