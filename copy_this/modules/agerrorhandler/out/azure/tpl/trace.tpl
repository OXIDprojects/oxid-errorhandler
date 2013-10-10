[{ if $trace.function }]
    at
    <strong>
        [{ $trace.class }]
        [{ $trace.type }][{ $trace.function }]
    </strong>
    ([{ $trace.args }])
[{ /if }]

[{ if $trace.file && $trace.line }]
    [{ if $trace.function }]<br/>[{/if}]
    in [{ $trace.file }] at line [{ $trace.line }]
    <a href="#" onclick="toggle('trace-[{$prefix}]-[{$prefix}]'); switchIcons('icon-[{$prefix}]-[{$prefix}]-open', 'icon-[{$prefix}]-[{$prefix}]-close'); return false;">
        <img class="toggle" id="icon-[{$prefix}]-[{$prefix}]-close" alt="-" src="data:image/gif;base64,R0lGODlhEgASAMQSANft94TG57Hb8GS44ez1+mC24IvK6ePx+Wa44dXs92+942e54o3L6W2844/M6dnu+P/+/l614P///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAABIALAAAAAASABIAQAVCoCQBTBOd6Kk4gJhGBCTPxysJb44K0qD/ER/wlxjmisZkMqBEBW5NHrMZmVKvv9hMVsO+hE0EoNAstEYGxG9heIhCADs=" style="display: [{ if 0 == $i }]inline[{else}]none[{/if}]" />
        <img class="toggle" id="icon-[{$prefix}]-[{$prefix}]-open" alt="+" src="data:image/gif;base64,R0lGODlhEgASAMQTANft99/v+Ga44bHb8ITG52S44dXs9+z1+uPx+YvK6WC24G+944/M6W28443L6dnu+Ge54v/+/l614P///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAABMALAAAAAASABIAQAVS4DQBTiOd6LkwgJgeUSzHSDoNaZ4PU6FLgYBA5/vFID/DbylRGiNIZu74I0h1hNsVxbNuUV4d9SsZM2EzWe1qThVzwWFOAFCQFa1RQq6DJB4iIQA7" style="display: [{ if 0 != $i }]inline[{else}]none[{/if}]" />
    </a>
    <div id="trace-[{$prefix}]-[{$prefix}]" style="display: [{ if 0 == $i }]block[{else}]none[{/if}]" class="trace">
         [{ $trace.lines }]
    </div>

[{ /if }]