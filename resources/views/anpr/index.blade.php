<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<div class="container">
    <h1>ANPR Detection Events</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>License Plate</th>
                <th>Event Time</th>
                <th>XML Path</th>
                <th>License Plate Image</th>
                <th>Detection Image</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->license_plate }}</td>
                <td>{{ $event->event_time }}</td>
                <td>
                    <a href="{{ asset('storage/tcp-data/xml/' . $event->xml_path) }}" target="_blank">
                        {{ $event->xml_path }}
                    </a>
                </td>
                <td>
                    <img src="{{ asset('storage/tcp-data/images/' . $event->license_plate_image_path) }}"
                        alt="License Plate" width="100">
                </td>
                <td>
                    <img src="{{ asset('storage/tcp-data/images/' . $event->detection_image_path) }}"
                        alt="Detection" width="100">
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No events found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{-- <div class="d-flex justify-content-center"> --}}
        {{-- {{ $events->links('vendor/pagination/simple-tailwind') }} --}}
        {{ $events->links() }}
    {{-- </div> --}}
</div>