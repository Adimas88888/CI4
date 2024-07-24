<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <div class="container">
        <h2>CRUD Application</h2>
        <button id="create-btn" class="btn btn-primary mb-3">Create Post</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="posts-table">
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="post-modal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="post-form">
                        <input type="hidden" id="post-id">
                        <div class="form-group">
                            <label for="post-title">Title</label>
                            <input type="text" class="form-control" id="post-title" required>
                        </div>
                        <div class="form-group">
                            <label for="post-body">Body</label>
                            <textarea class="form-control" id="post-body" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        fetchPosts();

        function fetchPosts() {
            $.ajax({
                url: '<?= site_url('crudcontroller/fetchAll') ?>',
                method: 'GET',
                success: function(data) {
                    console.log('Data fetched:', data); 
                    let posts = '';
                    data.forEach(post => {
                        posts += `<tr>
                            <td>${post.id}</td>
                            <td>${post.title}</td>
                            <td>${post.body}</td>
                            <td class="action-buttons">
                                <button class="btn btn-warning btn-sm edit-btn" data-id="${post.id}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${post.id}">Delete</button>
                            </td>
                        </tr>`;
                    });
                    $('#posts-table').html(posts);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                }
            });
        }

        $('#create-btn').click(function() {
            $('#post-modal').modal('show');
            $('#post-id').val('');
            $('#post-title').val('');
            $('#post-body').val('');
        });

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `<?= site_url('crudcontroller/fetchSingle/') ?>${id}`,
                method: 'GET',
                success: function(data) {
                    $('#post-id').val(data.id);
                    $('#post-title').val(data.title);
                    $('#post-body').val(data.body);
                    $('#post-modal').modal('show');
                }
            });
        });

        $('#post-form').submit(function(e) {
            e.preventDefault();
            const id = $('#post-id').val();
            const post = {
                title: $('#post-title').val(),
                body: $('#post-body').val()
            };
            const url = id ? `<?= site_url('crudcontroller/update/') ?>${id}` : '<?= site_url('crudcontroller/create') ?>';
            const method = id ? 'PUT' : 'POST';
            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify(post),
                success: function() {
                    $('#post-modal').modal('hide');
                    fetchPosts();
                    Swal.fire({
                        icon: 'success',
                        title: id ? 'Post Updated!' : 'Post Created!',
                        text: 'Your post has been successfully ' + (id ? 'updated' : 'created') + '.',
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                }
            });
        });

        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `<?= site_url('crudcontroller/delete/') ?>${id}`,
                        method: 'DELETE',
                        success: function(response) {
                            console.log('Delete success response:', response); 
                            Swal.fire('Deleted!', 'Your post has been deleted.', 'success');
                            fetchPosts(); 
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX error:', textStatus, errorThrown);
                        }
                    });
                }
            });
        });
    });
</script>

</body>
</html>
