</div></div>

<div id="footer">
    <div class="container hidden-xs">
        <div class="row">
            <div class="col-xs-8">
                <p class="text-muted credit">
                    &copy; <a href="https://www.nixsolutions.com">{{ config('cms.author') }}</a> 2016. All rights reserved.
                </p>
            </div>
            <div class="col-xs-4">
                <p class="text-muted credit pull-right">
                    Generated in {{ round((microtime(1) - LARAVEL_START), 4) }} sec.
                </p>
            </div>
        </div>
    </div>
    <div class="container visible-xs">
        <p class="text-muted credit">
            &copy; <a href="https://www.nixsolutions.com/ru/">{{ config('cms.author') }}</a> 2016. All rights reserved.
        </p>
    </div>
</div>

@section('js')
@show

@if (config('analytics.google'))
    @include('partials.analytics')
@endif
