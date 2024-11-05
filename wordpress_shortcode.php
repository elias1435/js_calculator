function client_session_calculator_shortcode() {
    ob_start();
    ?>
    <div class="calculator-container">
        <div class="form-group">
            <label for="session-frequency">Do you usually see clients weekly, biweekly, or monthly?</label>
            <select class="form-control" id="session-frequency">
                <option value="monthly">Monthly</option>
                <option value="weekly">Weekly</option>
                <option value="biweekly">Biweekly</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="session-fee">What is your session fee? <span class="range-value" id="session-fee-value">$10</span></label>
            <input type="range" class="form-control" id="session-fee" min="10" max="400" step="5" value="10">
            <div class="range-labels">
                <span>10</span>
                <span>75</span>
                <span>150</span>
                <span>225</span>
                <span>300</span>
                <span>375</span>
                <span>400</span>
            </div>
        </div>
        
        <div class="form-group">
            <label for="months">How many months (on average) do you work with a client? <span class="range-value" id="months-value">1</span></label>
            <input type="range" class="form-control" id="months" min="1" max="24" step="1" value="1">
            <div class="range-labels">
                <span>1</span>
                <span>6</span>
                <span>12</span>
                <span>18</span>
                <span>24</span>
            </div>
        </div>

        <div class="form-group">
            <label for="purchase-amount">Investment Value</label><br/>
            <input type="number" class="form-control" id="purchase-amount" min="0" max="1000" step="10" value="0">
        </div>

        <div id="result">
            <p class="big-font" style="padding-bottom: 10px;">Lifetime value = $<span id="lifetime-value">0</span> 💸</p>
		    <p class="small-font">How many clients will you need before you make your money back?<p>
            <p class="big-font">Just <span id="investment-value">0</span> Clients 💸</p>
		    <p class="big-font">Return on Investment: <span id="roi">0</span> %</p>
        </div>
    </div>

<style>
  #result {
    background-color: rgba(190, 214, 216, 1) !important;
    padding: 25px;
    border-radius: 0 0 30px 30px;
	margin-top: 20px;
	font-size: 1.2em;
	font-weight: bold;
}
  #result p {
	margin-bottom: 15px !important;
	color: #000 !important;
  }
  #result .big-font  {
    font-size: 30px !important;
    font-weight: bold !important;
}
  .calculator-container {
	max-width: 600px;
	margin: 0 auto;
	border: 1px solid #000;
    border-radius: 0 0 30px 30px;
  }
  .small-font {
	font-family: 'Open Sans', sans-serif !important;
    font-size: 15px !important;
	display: block;
	font-weight: 400 !important;
  }
  .form-group {
	margin-bottom: 20px;
	margin-bottom: 20px;
    padding: 20px 20px 0px;
  }
  .range-labels {
	display: flex;
	justify-content: space-between;
  }
  .range-value {
	text-align: right;
	font-weight: bold;
  }
  #session-frequency,
  input[type="range"], input[type="number"], input[type="number"] {
	width: 100%;
    max-width: 100% !important;
  }
  .form-group label {
	font-weight: bold;
  }
</style>

<script>
  function calculateValues() {
    const purchaseAmount = parseInt(document.getElementById('purchase-amount').value);

    const frequency = document.getElementById('session-frequency').value;
    const sessionFee = parseInt(document.getElementById('session-fee').value);
    const months = parseInt(document.getElementById('months').value);

    let sessionsPerMonth;
    if (frequency === 'monthly') {
      sessionsPerMonth = 1;
    } else if (frequency === 'weekly') {
      sessionsPerMonth = 4;
    } else {
      sessionsPerMonth = 8;
    }

    const lifetimeValue = sessionsPerMonth * sessionFee * months;
    const investmentValue = purchaseAmount / lifetimeValue;

    // ROI - Prevent division by zero or invalid values
    const roiValue = (purchaseAmount > 0) ? (lifetimeValue / purchaseAmount) * 100 : 0;

    // Update displayed values
    document.getElementById('lifetime-value').textContent = lifetimeValue.toFixed(2);
    document.getElementById('investment-value').textContent = investmentValue.toFixed(2);
    
    // Display the ROI value rounded to 2 decimal places
    document.getElementById('roi').textContent = roiValue.toFixed(2);

    // ROI - Ensure no additional calculations if values are undefined
    if (typeof lifetimeValue !== 'undefined' && typeof purchaseAmount !== 'undefined') {
      document.getElementById('roi').textContent = roiValue.toFixed(2);
    }
  }

  function updateSliderValue(id, value) {
    document.getElementById(id).textContent = value;
  }

  document.getElementById('session-frequency').addEventListener('change', calculateValues);
  document.getElementById('session-fee').addEventListener('input', function() {
    updateSliderValue('session-fee-value', '$' + this.value);
    calculateValues();
  });
  document.getElementById('months').addEventListener('input', function() {
    updateSliderValue('months-value', this.value);
    calculateValues();
  });
  document.getElementById('purchase-amount').addEventListener('input', calculateValues);

  // Initial calculation
  calculateValues();
</script>


<!-- <script>
  function calculateValues() {
	const purchaseAmount = parseInt(document.getElementById('purchase-amount').value);

	const frequency = document.getElementById('session-frequency').value;
	const sessionFee = parseInt(document.getElementById('session-fee').value);
	const months = parseInt(document.getElementById('months').value);

	let sessionsPerMonth;
	if (frequency === 'monthly') {
	  sessionsPerMonth = 1;
	} else if (frequency === 'weekly') {
	  sessionsPerMonth = 4;
	} else {
	  sessionsPerMonth = 8;
	}

	const lifetimeValue = sessionsPerMonth * sessionFee * months;
	const investmentValue = (purchaseAmount / lifetimeValue).toFixed(2);
	
	// ROI - Prevent division by zero or invalid values
    const roiValue = (investmentValue > 0) ? (lifetimeValue / investmentValue) * 100 : 0;

	document.getElementById('lifetime-value').textContent = lifetimeValue.toFixed(2);
	document.getElementById('investment-value').textContent = investmentValue;
	
	// ROI - Injection
	document.getElementById('roi').textContent = parseFloat(roiValue.toFixed(2));
	
	// ROI - is not zero
	if (typeof lifetimeValue !== 'undefined' && typeof investmentValue !== 'undefined') {
		const roiValue = (investmentValue > 0) ? (lifetimeValue / investmentValue) : 0;
		document.getElementById('roi').textContent = roiValue;
	}
	
	
  }

  function updateSliderValue(id, value) {
	document.getElementById(id).textContent = value;
  }

  document.getElementById('session-frequency').addEventListener('change', calculateValues);
  document.getElementById('session-fee').addEventListener('input', function() {
	updateSliderValue('session-fee-value', '$' + this.value);
	calculateValues();
  });
  document.getElementById('months').addEventListener('input', function() {
	updateSliderValue('months-value', this.value);
	calculateValues();
  });
  document.getElementById('purchase-amount').addEventListener('input', calculateValues);

  // Initial calculation
  calculateValues();
</script> -->

    <?php
    return ob_get_clean();
}

add_shortcode('client_session_calculator', 'client_session_calculator_shortcode');
