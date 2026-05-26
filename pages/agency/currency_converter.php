<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        #converter {
            max-width: 500px;
            margin: 40px auto;
            padding: 24px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        #converter input,
        #converter select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        #result {
            font-size: 1.4rem;
            font-weight: bold;
            margin-top: 12px;
        }

        #error {
            color: red;
        }
    </style>
</head>

<body>

    <div id="converter">
        <a href="agency_dashboard.php">Go Back</a>
        <h2>Currency Converter</h2>

        <label>Amount</label>
        <input type="number" id="amount" value="1" min="0" step="any">

        <label>From</label>
        <select id="from-currency"></select>

        <label>To</label>
        <select id="to-currency"></select>

        <button onclick="convert()">Convert</button>

        <p id="result"></p>
        <p id="error"></p>
        <p id="rate-info" style="color:#888; font-size:0.85rem;"></p>
    </div>

    <script>
        let rates = {};

        // Load rates on page load (default base USD)
        fetchRates('USD');

        function fetchRates(base) {
            document.getElementById('error').textContent = '';

            fetch(`../../api/currency_converter.php?base=${base}`)
                .then(r => r.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('error').textContent = data.error;
                        return;
                    }

                    rates = data.rates;
                    populateDropdowns(data.base, Object.keys(rates));
                    document.getElementById('rate-info').textContent =
                        `Rates based on 1 ${data.base} — updated ${data.date}`;
                });
        }

        function populateDropdowns(base, currencies) {
            const from = document.getElementById('from-currency');
            const to = document.getElementById('to-currency');

            from.innerHTML = '';
            to.innerHTML = '';

            currencies.forEach(code => {
                const optFrom = document.createElement('option');
                optFrom.value = optFrom.textContent = code;
                if (code === base) optFrom.selected = true;
                from.appendChild(optFrom);

                const optTo = document.createElement('option');
                optTo.value = optTo.textContent = code;
                if (code === 'ZAR') optTo.selected = true; // default to ZAR since you're SA
                to.appendChild(optTo);
            });
        }

        // When "from" changes, re-fetch with new base for accuracy
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('from-currency').addEventListener('change', function() {
                fetchRates(this.value);
            });
        });

        function convert() {
            const amount = parseFloat(document.getElementById('amount').value);
            const from = document.getElementById('from-currency').value;
            const to = document.getElementById('to-currency').value;

            if (isNaN(amount) || amount < 0) {
                document.getElementById('error').textContent = 'Please enter a valid amount.';
                return;
            }

            if (!rates[to]) {
                document.getElementById('error').textContent = 'Rate not available.';
                return;
            }

            const converted = (amount * rates[to]).toFixed(2);
            document.getElementById('result').textContent =
                `${amount} ${from} = ${converted} ${to}`;
            document.getElementById('error').textContent = '';
        }
    </script>

</body>

</html>