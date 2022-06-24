<!doctype html>
<html lang="en">
<head>
    <title>Laravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container py-2">
        <div class="text-center">
            <h5 class=" font-weight-bold">HISTORY ROOM_911</h5>
        </div>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th class="text-center">Full Name</th>
                    <th class="text-center">Document number</th>
                    <th class="text-center">Access date</th>
                    <th class="text-center">Entries</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($entries as $entry)
                    <tr>
                        <td class="text-center">{{ $entry->employee_id ? $entry->employee->full_name : "Unknown" }}</td>
                        <td class="text-center">{{$entry->document_number ? $entry->document_number : $entry->employee->document_number }}</td>
                        <td class="text-center">{{ $entry->created_at }}</td>
                        <td class="text-center {{$entry->entry_action == "YES" ? "text-success" : "text-danger"}}">{{ $entry->entry_action }}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
