@props(['contents' => $contents, 'availableLangs' => $availableLangs])

@foreach($contents as $content)
    <div class="card mb-1 content-body" id="{{ $loop->iteration }}">
        <div class="card-header">
            @php $optionValues = ['text' => 'Text', 'image-small' => 'Small Image', 'image-big' => 'Wide Image', 'slide' => 'Slide']; @endphp
            <label for="content-type">{{ __('Content type') }}</label>
            <select form="project-create-form" class="custom-select"
                    name="content[{{ $loop->iteration }}][type]"
                    onchange="changeContentType(this)">
                @foreach($optionValues as $val => $text)
                    <option
                        value="{{ $val }}" {{ $content['type'] ===  $val ? 'selected' : '' }}>{{ __($text) }}</option>
                @endforeach
            </select>
        </div>
        <div class="card-content pb-1">
            <div class="card-body pb-0">
                @switch($content->type)
                    @case('text')
                    <x-dashboard.language-tabs :availableLangs="$availableLangs"
                                               :key="$loop->iteration"
                                               :hasMultiValuedInput="true"/>
                    <x-dashboard.project-text-content :availableLangs="$availableLangs"
                                                      :key="$loop->iteration"
                                                      :content="$content"/>
                    @break

                    @case('image-small')
                    @case('image-big')
                    <x-dashboard.project-image-content :content="$content" :key="$loop->iteration"/>
                    @break

                    @case('slide')
                    <x-dashboard.project-slide-content :content="$content" :key="$loop->iteration"/>
                    @break
                @endswitch
            </div>
        </div>

        <div class="card-footer">
            <i class="feather icon-trash-2 text-danger pr-1 remove-content"
               onclick="removeContent(this)"></i>
        </div>
    </div>
@endforeach
