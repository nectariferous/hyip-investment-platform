

<form action="{{$data->redirect_url}}" method="POST" id="submit">
    @foreach($data->paytm_params as $key=> $params)
        <input type="hidden" name="{{$key}}" value="{{$params}}"/>
    @endforeach
</form>
<script>
	"use strict";
    document.getElementById("submit").submit();
</script>