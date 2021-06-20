<form action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
    <!-- Add CSRF Token -->
    @csrf
    <div class="form-group">
        <label>Product Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="form-group">
        <input type="file" name="file" required>
    </div>
    <button type="submit">Submit</button>
</form>
