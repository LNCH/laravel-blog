<h4>{{ isset($tag) ? "Edit" : "New" }} Tag{{ isset($tag) ? "" : "s" }}</h4>

<form action="{{ isset($tag) ? blogUrl("tags/$tag->id") : blogUrl("tags") }}" method="post">
    {{ csrf_field() }} {{ method_field(isset($tag) ? "PATCH" : "POST") }}

    @if(!isset($tag))
        <p>To create multiple tags, separate each tag with a comma.</p>
    @endif

    <div class="form-group">
        <label for="tags" class="control-label">Tags</label>
        <input type="text" class="form-control" id="tags" name="{{ isset($tag) ? "tag" : "tags" }}" value="{{ old("tags", isset($tag) ? $tag->name : "") }}" />
    </div>

    <div class="form-group">
        <button class="btn btn-success btn-block">{{ isset($tag) ? "Update Tag" : "Create Tags" }}</button>
    </div>

</form>