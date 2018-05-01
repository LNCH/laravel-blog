<form action="{{ isset($category) ? blogUrl("categories/$category->id") : blogUrl("categories") }}" method="post">
    {{ csrf_field() }} {{ method_field(isset($category) ? "PATCH" : "POST") }}

    @if(isset($category))
        <input type="hidden" name="category_id" value="{{ $category->id }}" />
    @endif

    <div class="form-group @if($errors->has("name")) has-error @endif">
        <label for="name" class="control-label">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" required="required"
               value="{{ old("name", isset($category) ? $category->name : "") }}" />
    </div>

    <div class="form-group @if($errors->has("description")) has-error @endif">
        <label for="description" class="control-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="10">{{--
                        --}}{{ old("description", isset($category) ? $category->description : "") }}{{--
                    --}}</textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-success">{{ isset($category) ? "Update" : "Create" }} Category</button>
    </div>

</form>