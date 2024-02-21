<div class="card">
    <div class="card-body">
        <table class="w-full">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Subject</th>
                    <th>Submissions</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @foreach($user->assignments as $assignment)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $assignment->subject->name }}</td>
                            <td>{{ count($assignment->submissions) }}</td>
                            <td>{{ $assignment->submissionRate }}%</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
