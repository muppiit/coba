<!DOCTYPE html>
<html>

<head>
    <title>{{ $title ?? 'Aplikasi Persuratan' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('transaction.surat.index') }}">Persuratan</a>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let searchInput = document.getElementById('search-input');
        let clearBtn = document.getElementById('clear-search');
        let dataContainer = document.getElementById('data-container');
        let loadingDiv = document.getElementById('loading');
        let searchTimeout;

        if (typeof XMLHttpRequest === 'undefined') {
            document.getElementById('traditional-search').style.display = 'block';
            searchInput.style.display = 'none';
            return;
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(function() {
                let searchValue = searchInput.value.trim();
                performSearch(searchValue);
            }, 300); 
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            performSearch('');
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                let url = e.target.closest('.pagination a').href;
                let searchValue = searchInput.value.trim();
                let urlParams = new URLSearchParams(url.split('?')[1]);
                let page = urlParams.get('page');

                performSearch(searchValue, page);
            }
        });

        function performSearch(searchValue, page = 1) {
            loadingDiv.style.display = 'block';
            dataContainer.style.opacity = '0.5';

            let url = "{{ route('transaction.surat.get_data') }}";
            let params = new URLSearchParams();

            if (searchValue) {
                params.append('search', searchValue);
            }
            if (page > 1) {
                params.append('page', page);
            }

            fetch(url + '?' + params.toString(), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    dataContainer.innerHTML = html;
                    let newUrl = "{{ route('transaction.surat.index') }}";
                    if (searchValue) {
                        newUrl += '?search=' + encodeURIComponent(searchValue);
                    }
                    window.history.pushState({}, '', newUrl);
                })
                .catch(error => {
                    console.error('Error:', error);
                    dataContainer.innerHTML =
                        '<div class="alert alert-danger">Terjadi kesalahan saat memuat data.</div>';
                })
                .finally(() => {
                    loadingDiv.style.display = 'none';
                    dataContainer.style.opacity = '1';
                });
        }
    });
</script>

</html>
