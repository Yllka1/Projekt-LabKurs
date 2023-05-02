
    <div class="py-4 mt-5 bg-light">
        <div class="container">
            <p class="text-center m-0 p-0">Copyrights &copy; e-commerce, 2022.</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        const search = document.querySelector('#search')

        if(search) {
            search.addEventListener('keyup', e => {
                e.preventDefault()
                switch(e.keyCode) {
                    case 13:
                        window.location.href = `http://localhost/ecommerce/shop.php?search=${e.target.value}`
                        break
                }
            })
        }
    </script>
</body>
</html>