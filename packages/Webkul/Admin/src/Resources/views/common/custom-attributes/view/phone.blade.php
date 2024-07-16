@if (is_array($value))

    @foreach ($value as $item)
        <button class="multi-value" onclick="makeManualCall('{{ $item['value'] }}')">
            {{ $item['value'] }}
            <span>{{ ' (' . $item['label'] . ')' }}</span>
        </button>
    @endforeach
@else
    {{ __('admin::app.common.not-available') }}
@endif
