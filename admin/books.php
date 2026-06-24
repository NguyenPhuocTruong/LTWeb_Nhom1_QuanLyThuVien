<!DOCTYPE html>
<html>

<head>
    <title>Books</title>
    <link rel="stylesheet" href="../assets/css/reset.css">

    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/books.css">

    <script src="https://kit.fontawesome.com/67ecaf9947.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include "../header.php"; ?>

    <div class="books-page">

        <div class="admin-layout">

            <?php include "sidebar.php"; ?>

            <main class="books-content">

                <div class="books-header">
                    <h2>Manage Books</h2>
                    <button class="btn-add">+ Add Book</button>
                </div>

                <div class="books-table-box">
                    <table class="books-table">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>ISBN</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Category</th>
                                <th>Rack</th>
                                <th>No of copy</th>
                                <th>Status</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>The Joy of PHP</td>
                                <td>12345</td>
                                <td>Alan Forbes</td>
                                <td>Plum Island</td>
                                <td>Programming</td>
                                <td>R2</td>
                                <td>10</td>
                                <td>Enable</td>
                                <td>2026-06-24</td>
                                <td>
                                    <button class="btn-edit">Edit</button>
                                    <button class="btn-delete">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </main>

        </div>

    </div>

    <?php include "../footer.php"; ?>

</body>

</html>