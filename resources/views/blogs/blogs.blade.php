@auth
    @if(auth()->user()->role == 'admin')
        <x-app-layout>
            <link rel="stylesheet" href="css/user.css">

            <main class="main-content">
                <div class="dashboard-content">
                    <div class="container">
                        <div class="header">
                            <h1 class="title">User List</h1>
                        </div>

                        <div class="controls">
                            <div class="search-container">
                                <input type="text" class="search-input" placeholder="Search" id="searchInput">
                            </div>
                            @auth
                                @if(auth()->user()->role == 'admin')
                                    <div class="export-buttons">
                                            <a  class="export-btn print-btn" href="blog_update"><i class="fa-solid fa-rss"></i> Add Blog</a>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <div class="table-container">
                            <table class="user-table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Subhead</th>
                                        <th>Description</th>
                                        <th>Tags</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody"></tbody>
                            </table>
                        </div>

                        <div class="pagination-container">
                            <div class="pagination-info" id="paginationInfo">Showing 1 to 5 of 0 entries</div>
                            <div class="pagination" id="pagination">
                                <button class="pagination-btn" id="prevBtn">Previous</button>
                                <div class="page-numbers" id="pageNumbers"></div>
                                <button class="pagination-btn" id="nextBtn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <script>
                const initialUserData = @json($users);
            </script>

            <script>
                const userData = initialUserData.map(user => ({
                    id: user.id,
                    img: user.img,
                    title: user.title,
                    hash: user.hash,
                    disc: user.disc,
                    role: user.role,
                    joinDate: new Date(user.created_at).toLocaleDateString(),
                    avatar: '/placeholder.svg?height=40&width=40'
                }));

                let currentPage = 1;
                let itemsPerPage = 5;
                let filteredData = [...userData];
                let searchTerm = '';

                const tableBody = document.getElementById('tableBody');
                const searchInput = document.getElementById('searchInput');
                const paginationInfo = document.getElementById('paginationInfo');
                const pageNumbers = document.getElementById('pageNumbers');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');

                document.addEventListener('DOMContentLoaded', function () {
                    renderTable();
                    renderPagination();
                    setupEventListeners();
                });

                function setupEventListeners() {
                    searchInput.addEventListener('input', handleSearch);
                    prevBtn.addEventListener('click', () => changePage(currentPage - 1));
                    nextBtn.addEventListener('click', () => changePage(currentPage + 1));
                }

                function handleSearch(e) {
                    searchTerm = e.target.value.toLowerCase().trim();
                    filteredData = searchTerm === '' ? [...userData] : userData.filter(user =>
                        user.name.toLowerCase().includes(searchTerm) ||
                        user.email.toLowerCase().includes(searchTerm) ||
                        user.contact.toLowerCase().includes(searchTerm) ||
                        user.status.toLowerCase().includes(searchTerm) ||
                        user.role.toLowerCase().includes(searchTerm)
                    );
                    currentPage = 1;
                    renderTable();
                    renderPagination();
                }

                function renderTable() {
                    const startIndex = (currentPage - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;
                    const currentData = filteredData.slice(startIndex, endIndex);

                    if (currentData.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="8" class="no-results">
                            <i class="fas fa-search"></i>
                            <div>No results found</div>
                            <small>Try adjusting your search terms</small>
                        </td></tr>`;
                        return;
                    }

                    tableBody.innerHTML = currentData.map(user => `
                        <tr>
                            <td><img src="storage/app/public/${user.img}" alt="${user.title}" class="profile-img-blog"></td>
                            <td style="width: 200px;">
  <div style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 1.4em; max-height: 4.2em; white-space: normal;">
    ${user.title}
  </div>
</td>
<td style="width: 200px;">
  <div style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 1.4em; max-height: 4.2em; white-space: normal;">
    ${user.hash}
  </div>
</td>
<td style="width: 200px;">
  <div style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 1.4em; max-height: 4.2em; white-space: normal;">
    ${user.disc}
  </div>
</td>

                            <td>${user.tags == '' ?  user.tags : '-'}</td>
                            <td><span class="badge ${user.status === 'Y' ? 'iq-bg-primary' : 'iq-bg-danger'}">${user.status === 'Y' ? 'Active' : 'Inactive'}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn delete-btn" onclick="handleAction('delete', '${user.name}', ${user.id})"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    `).join('');
                }

                function renderPagination() {
                    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                    const startItem = filteredData.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
                    const endItem = Math.min(currentPage * itemsPerPage, filteredData.length);
                    paginationInfo.textContent = `Showing ${startItem} to ${endItem} of ${filteredData.length} entries`;

                    prevBtn.disabled = currentPage === 1;
                    nextBtn.disabled = currentPage === totalPages || totalPages === 0;

                    generatePageNumbers(totalPages);
                }

                function generatePageNumbers(totalPages) {
                    pageNumbers.innerHTML = '';
                    if (totalPages <= 1) return;

                    for (let i = 1; i <= totalPages; i++) {
                        const btn = document.createElement('button');
                        btn.className = `pagination-btn ${i === currentPage ? 'active' : ''}`;
                        btn.textContent = i;
                        btn.addEventListener('click', () => changePage(i));
                        pageNumbers.appendChild(btn);
                    }
                }

                function changePage(newPage) {
                    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                    if (newPage < 1 || newPage > totalPages) return;
                    currentPage = newPage;
                    renderTable();
                    renderPagination();
                    document.querySelector('.table-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                function handleAction(action, name, id) {
                    alert(`${action.toUpperCase()} ${name} (ID: ${id})`);
                }

                // The handlePrint and handleExcelExport functions are removed.
            </script>
            
            <script>
                function handleAction(action, name, id) {
    if (action === 'delete') {
        if (confirm(`Are you sure you want to delete blog: ${name}?`)) {
            fetch(`/delete-blog/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Blog deleted successfully!');
                    // Remove deleted blog from userData and re-render
                    const index = userData.findIndex(blog => blog.id === id);
                    if (index !== -1) {
                        userData.splice(index, 1);
                        filteredData = [...userData];
                        renderTable();
                        renderPagination();
                    }
                } else {
                    alert('Failed to delete blog.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting.');
            });
        }
    } else {
        alert(`${action.toUpperCase()} ${name} (ID: ${id})`);
    }
}

            </script>
        </x-app-layout>
    @else
        <script>window.location.href = "dashboard";</script>
    @endif
@endauth