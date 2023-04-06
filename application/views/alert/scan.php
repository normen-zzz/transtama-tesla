<html>

<body>
 <h1>Sukses scan</h1>
    <h1>You will be redirected in 3 seconds</h1>
    <script>
        var timer = setTimeout(function() {
            window.location = '<?= base_url('shipper/Scan/successScan/'.$result_code) ?>'
        }, 3000);
    </script>
</body>

</html>