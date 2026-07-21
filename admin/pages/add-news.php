<main id="main">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h4>Add New Record</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">

                <!-- Category -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">Select Category</option>
                        <!-- Dynamic categories -->
                        <option value="1">Category 1</option>
                        <option value="2">Category 2</option>
                    </select>
                </div>

            

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        name="title"
                        placeholder="Enter title"
                        required>
                </div>

                <!-- Slug -->
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input
                        type="text"
                        class="form-control"
                        id="slug"
                        name="slug"
                        placeholder="enter-slug">
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input
                        type="file"
                        class="form-control"
                        id="image"
                        name="image"
                        accept="image/*">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        class="form-control"
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Enter description"></textarea>
                </div>

                <!-- Meta Title -->
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input
                        type="text"
                        class="form-control"
                        id="meta_title"
                        name="meta_title"
                        placeholder="Enter meta title">
                </div>

                <!-- Meta Description -->
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea
                        class="form-control"
                        id="meta_description"
                        name="meta_description"
                        rows="3"
                        placeholder="Enter meta description"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save
                </button>

                <button type="reset" class="btn btn-secondary">
                    Reset
                </button>

            </form>
        </div>
    </div>
</div>
</main>