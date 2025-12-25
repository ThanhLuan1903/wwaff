<style>
    body {
        font-family: 'Arial', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f5f8fa;
    }

    .notification-container {
        width: 80%;
        max-width: 600px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .notification-header {
        background-color: #f4d906;
        color: white;
        padding: 18px 24px;
        font-size: 20px;
        font-weight: bold;
        display: flex;
        align-items: center;
    }

    .header-icon {
        margin-right: 12px;
        font-size: 22px;
    }

    .notification-body {
        padding: 30px 25px;
        line-height: 1.5;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .wallet-icon-wrapper {
        position: relative;
        margin-bottom: 25px;
    }

    .wallet-icon {
        width: 80px;
        height: 80px;
        color: #f4d906;
        opacity: 0.9;
    }

    .notification-title {
        font-size: 20px;
        font-weight: 600;
        color:rgba(80, 73, 19, 1);
        margin-bottom: 12px;
    }

    .notification-detail {
        font-size: 15px;
        color: rgba(96, 88, 29, 1);
        margin-bottom: 25px;
        max-width: 90%;
        line-height: 1.6;
    }

</style>
</head>

<body>
    <div class="notification-container">
        <div class="notification-header">
            <i class="fas fa-wallet header-icon"></i>
            Budget Reached
        </div>
        <div class="notification-body">
            <div class="wallet-icon-wrapper">
                <svg class="wallet-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 14h.01"></path>
                    <path d="M7 7h12a4 4 0 0 1 4 4v6a4 4 0 0 1-4 4H5a4 4 0 0 1-4-4V9a4 4 0 0 1 4-4h2"></path>
                    <path d="M5 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2"></path>
                    <path d="M13 11h6a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-6"></path>
                </svg>
            </div>
            <div class="notification-title">Monthly Budget Exceeded</div>
            <div class="notification-detail">
                Offer has reached this month's budget. Please come back on the begin of next month GMT - 5.
            </div>
        </div>
    </div>
</body>