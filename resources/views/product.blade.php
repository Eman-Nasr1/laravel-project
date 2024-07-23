<!-- resources/views/product.blade.php -->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Product List</h1>

        <div id="alert-success" class="alert alert-success" style="display: none;"></div>

        <!-- Form to add a new product -->
        <div class="card mb-5">
            <div class="card-header">Add New Product</div>
            <div class="card-body">
                <form id="addProductForm">
                    @csrf
                    <div class="mb-3">
                        <label for="ProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="ProductName" name="ProductName" required>
                    </div>
                    <div class="mb-3">
                        <label for="ProductPrice" class="form-label">Product Price</label>
                        <input type="text" class="form-control" id="ProductPrice" name="ProductPrice" required>
                    </div>
                    <div class="mb-3">
                        <label for="ProductQuantity" class="form-label">Product Quantity</label>
                        <input type="text" class="form-control" id="ProductQuantity" name="ProductQuantity" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Product</button>
                </form>
            </div>
        </div>

        <!-- Table to display products -->
        <table class="table table-bordered" id="productTable">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Price</th>
                    <th scope="col">Product Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#addProductForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ url("/add-product") }}',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#alert-success').text(response.success).show();
                        var product = response.product;
                        $('#productTable tbody').append('<tr><td>' + product.name + '</td><td>' + product.price + '</td><td>' + product.quantity + '</td></tr>');
                        $('#addProductForm')[0].reset();
                    },
                    error: function (response) {
                        // Handle error here
                    }
                });
            });
        });
    </script>
</body>
</html>
