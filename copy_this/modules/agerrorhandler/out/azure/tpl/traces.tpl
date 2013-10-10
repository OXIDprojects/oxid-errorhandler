<div class="block">
    <h2>
        <span><small>[{ $position }] / [{ $position }]</small></span>
        [{ $exception->class }]: [{ $exception->message|nl2br}]&nbsp;
        <a href="#" onclick="toggle('traces-{{ position }}', 'traces'); switchIcons('icon-traces-{{ position }}-open', 'icon-traces-{{ position }}-close'); return false;">
            <img class="toggle" id="icon-traces-{{ position }}-close" alt="-" src="data:image/gif;base64,R0lGODlhEgASAMQSANft94TG57Hb8GS44ez1+mC24IvK6ePx+Wa44dXs92+942e54o3L6W2844/M6dnu+P/+/l614P///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAABIALAAAAAASABIAQAVCoCQBTBOd6Kk4gJhGBCTPxysJb44K0qD/ER/wlxjmisZkMqBEBW5NHrMZmVKvv9hMVsO+hE0EoNAstEYGxG9heIhCADs=" style="display: {{ 0 == count ? 'inline' : 'none' }}" />
            <img class="toggle" id="icon-traces-{{ position }}-open" alt="+" src="data:image/gif;base64,R0lGODlhEgASAMQTANft99/v+Ga44bHb8ITG52S44dXs9+z1+uPx+YvK6WC24G+944/M6W28443L6dnu+Ge54v/+/l614P///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAABMALAAAAAASABIAQAVS4DQBTiOd6LkwgJgeUSzHSDoNaZ4PU6FLgYBA5/vFID/DbylRGiNIZu74I0h1hNsVxbNuUV4d9SsZM2EzWe1qThVzwWFOAFCQFa1RQq6DJB4iIQA7" style="display: {{ 0 == count ? 'none' : 'inline' }}" />
        </a>
    </h2>

    <a id="traces-link-{{ position }}"></a>
    <ol class="traces list-exception" id="traces-{{ position }}" style="display: {{ 0 == count ? 'block' : 'none' }}">
        [{ foreach from=$exception->traces item=trace name=traces }]
            <li>
                [{ include file="trace.tpl" prefix=$smarty.foreach.traces.iteration trace=$trace i=$smarty.foreach.traces.iteration-1 }]
            </li>
        [{ /foreach }]
    </ol>
</div>