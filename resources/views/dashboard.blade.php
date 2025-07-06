<x-app-layout>
    <main class="main-content">
        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Metrics Cards -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-header">
                        <h3>Revenue</h3>
                        <span class="metric-badge monthly">Monthly</span>
                    </div>
                    <div class="metric-value">$35000</div>
                    <div class="metric-subtitle">Total Revenue</div>
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress-fill blue" style="width: 35%"></div>
                        </div>
                        <span class="progress-text">35%</span>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <h3>Orders</h3>
                        <span class="metric-badge annual">Annual</span>
                    </div>
                    <div class="metric-value">2500</div>
                    <div class="metric-subtitle">New Orders</div>
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress-fill orange" style="width: 24%"></div>
                        </div>
                        <span class="progress-text">24%</span>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <h3>Leads</h3>
                        <span class="metric-badge today">Today</span>
                    </div>
                    <div class="metric-value">$55000</div>
                    <div class="metric-subtitle">New Leads</div>
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress-fill red" style="width: 50%"></div>
                        </div>
                        <span class="progress-text">50%</span>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <h3>Lead Conversion Rate</h3>
                        <span class="metric-badge this-month">This Month</span>
                    </div>
                    <div class="metric-value">35%</div>
                    <div class="metric-subtitle">This Month</div>
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress-fill purple" style="width: 5%"></div>
                        </div>
                        <span class="progress-text">5%</span>
                    </div>
                </div>
            </div>

            <!-- Currency Converter and Chart Section -->
            <div class="bottom-section">
                <div class="currency-section">
                    <div class="currency-card">
                        <h3>1 United States Dollar Equals</h3>
                        <div class="currency-value">76.50 Indian Rupee</div>
                        <div class="currency-date">24 Apr 6:00 am UTC Declaration</div>

                        <div class="currency-inputs">
                            <div class="currency-input-group">
                                <input type="number" value="1" class="currency-input">
                                <select class="currency-select">
                                    <option>United State</option>
                                </select>
                            </div>
                            <div class="currency-input-group">
                                <input type="number" value="76.50" class="currency-input">
                                <select class="currency-select">
                                    <option>Indian Rupee</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="orders-section">
                        <div class="section-header">
                            <h3>Orders</h3>
                            <button class="more-btn">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                        <div class="orders-chart">
                            <div class="order-item">
                                <span class="order-value">2,500</span>
                            </div>
                            <div class="order-item">
                                <span class="order-value">2,000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-section">
                    <canvas id="areaChart" class="area-chart"></canvas>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
