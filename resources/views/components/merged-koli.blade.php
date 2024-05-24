<!-- resources/views/components/merged-koli.blade.php -->
@props(['record'])

<div>
    <strong>Koli:</strong><br>
    @foreach ($record->koli as $item)
        <span>{{ $item }}</span><br>
    @endforeach
</div>
