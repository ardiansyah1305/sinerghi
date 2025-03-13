<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="<?= site_url("pegawai/jabatan/upload") ?>" method="post" enctype="multipart/form-data">
        <label for="filename">File :</label> <br>
        <input type="file" name="filename" id="filename" accept=".csv, .xlsx" required>
        
        <button type="submit">upload</button>

    </form>


</body>

</html>