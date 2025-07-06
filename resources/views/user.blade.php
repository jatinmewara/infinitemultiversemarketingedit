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
                    <div class="export-buttons">
                        <button class="export-btn print-btn">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button class="export-btn excel-btn">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Join Date</th>
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

    <!-- Inject Laravel $users into JavaScript -->
    <script>
        const initialUserData = @json($users);
    </script>

    <script>
        const userData = initialUserData.map(user => ({
            id: user.id,
            name: user.name,
            contact: user.mobile ?? 'N/A',
            email: user.email,
            status: user.status,
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
            document.querySelector('.print-btn').addEventListener('click', handlePrint);
            document.querySelector('.excel-btn').addEventListener('click', handleExcelExport);
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
                    <td><img src="${user.avatar}" alt="${user.name}" class="profile-img"></td>
                    <td>${user.name}</td>
                    <td>${user.contact}</td>
                    <td>${user.email}</td>
                    <td><span class="badge ${user.status === 'Y' ? 'iq-bg-primary' : 'iq-bg-danger'}">${user.status === 'Y' ? 'Active' : 'Inactive'}</span></td>
                    <td>${user.role}</td>
                    <td>${user.joinDate}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn view-btn" onclick="handleAction('view', '${user.name}', ${user.id})"><i class="fas fa-eye"></i></button>
                            <button class="action-btn edit-btn" onclick="handleAction('edit', '${user.name}', ${user.id})"><i class="fas fa-edit"></i></button>
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

        function handlePrint() {
            const printWindow = window.open('', '_blank');
            const tableHTML = document.querySelector('.table-container').outerHTML;
            printWindow.document.write(`
                <html>
                    <head><title>Print Users</title>
                    <style>
                        body { font-family: sans-serif; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { padding: 8px; border: 1px solid #ccc; }
                        th { background-color: #f3f4f6; }
                        .action-buttons { display: none; }
                    </style></head>
                    <body><h1>User List</h1>${tableHTML}</body>
                </html>`);
            printWindow.document.close();
            printWindow.print();
        }

        function handleExcelExport() {
            const headers = ['Name', 'Contact', 'Email', 'Status', 'Role', 'Join Date'];
            const rows = filteredData.map(user => [user.name, user.contact, user.email, user.status, user.role, user.joinDate]);
            const csv = [headers.join(',')].concat(rows.map(row => row.map(v => `"${v}"`).join(','))).join('\n');

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'user_list.csv';
            link.click();
            URL.revokeObjectURL(url);
        }
    </script>
</x-app-layout>
