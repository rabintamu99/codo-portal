<style>
    .submission-table {
        width: 100%;
        border-collapse: collapse;
    }

    .submission-table th, .submission-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .submission-table th {
        background-color: #f4f4f4;
    }

    .submission-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .submission-table tr:hover {
        background-color: #f6f8b9;
    }

    .submission-button {
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .submission-button:hover {
        background-color: #45a049;
    }
</style>

<div>
    @if($submittedUsers->isNotEmpty())
        <table class="submission-table">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>学籍番号</th>
                    <th>提出状況</th>
                    <th>フアィル</th>
                    {{-- <th>状況変更</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($submittedUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->student_id }}</td>
                        <td>  &#x2714;</td>
                        <td>
                            @if($user->pivot->file_path)
                                <a href="{{ asset('storage/' . $user->pivot->file_path) }}" download>
                                    ダウンロード&#x2B07; <!-- Unicode down arrow -->
                                </a>
                            @else
                                フアィルありません。
                            @endif
                        </td>
                        {{-- <td>
                            <form method="POST" action="{{ route('change-submission-status', $user->id) }}">
                                @csrf
                                <button type="submit" class="submission-button">Change Status</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>まだ提出はありません。</p>
    @endif
</div>
