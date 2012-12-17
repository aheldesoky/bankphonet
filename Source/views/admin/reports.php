<div class="reports">
    
    <div class="reportitem">
        <h2>Credit of all accounts : </h2>
        <span><?=$report['credit'] ?> EGP</span>
    </div>
    
    
    <div class="reportitem">
        <h2>Transactions :</h2>
        <div>
            <div class="inneritem">
				<span>Today: </span><span><?=($report['t_today']) ? $report['t_today'] : '0'?> EGP</span>
			</div>
			<div class="inneritem">
            <span>Yesterday: </span><span><?=($report['t_yesterday']) ? $report['t_yesterday'] : '0'?> EGP</span>
			</div>
			<div class="inneritem">
            <span>Last month: </span><span><?=($report['t_month']) ? $report['t_month'] : '0'?> EGP</span>
			</div>
			<div class="inneritem">
            <span>Last Year: </span><span><?=($report['t_year']) ? $report['t_year'] : '0'?> EGP</span>
			</div>
        </div>
    </div>
    
    <div class="reportitem">
        <h2>Withdraw :</h2>
        <div>
			<div class="inneritem">
            <span>Today: </span><span><?=($report['w_today']) ? $report['w_today'] : '0'?> EGP</span>
			</div>
			<div class="inneritem">
            <span>Yesterday: </span><span><?=($report['w_yesterday']) ? $report['w_yesterday'] : '0'?> EGP</span>
			</div>
			<div class="inneritem">
            <span>Last month: </span><span><?=($report['w_month']) ? $report['w_month'] : '0'?> EGP</span>
			</div>
			<div class="inneritem">
            <span>Last Year: </span><span><?=($report['w_year']) ? $report['w_year'] : '0'?> EGP</span>
			</div>
        </div>
    </div>
    
    <div class="reportitem">
        <h2>Deposit :</h2>
        <div>
			<div class="inneritem">
				<span>Today: </span><span><?=($report['d_today']) ? $report['d_today'] : '0'?> EGP</span>
			</div>
			<div class="inneritem">
				<span>Yesterday: </span><span><?=($report['d_yesterday']) ? $report['d_yesterday'] : '0'?> EGP</span>
			</div>

			<div class="inneritem">
				<span>Last month: </span><span><?=($report['d_month']) ? $report['d_month'] : '0'?> EGP</span>
			</div>

			<div class="inneritem">
				<span>Last Year: </span><span><?=($report['d_year']) ? $report['d_year'] : '0'?> EGP</span>
			</div>
        </div>
    </div>
    
    <div class="reportitem">
        <h2>Super admin income :</h2>
        <div>
			<div class="inneritem">
				<span>Today: </span><span><?=($report['s_today']) ? $report['s_today'] : '0'?> EGP</span>
			</div>
			<div class="inneritem">
				<span>Yesterday: </span><span><?=($report['s_yesterday']) ? $report['s_yesterday'] : '0'?> EGP</span>
			</div>

			<div class="inneritem">
				<span>Last month: </span><span><?=($report['s_month']) ? $report['s_month'] : '0'?> EGP</span>
			</div>

			<div class="inneritem">
				<span>Last Year: </span><span><?=($report['s_year']) ? $report['s_year'] : '0'?> EGP</span>
			</div>
        </div>
    </div>



	<div class="reportitem">
        <h2>Net income :</h2>
        <div>
			<div class="inneritem">
				<span>Today: </span><span><?=($report['s_today']) ? $report['s_today'] - $report['w_today']  : '0'?> EGP</span>
			</div>
			<div class="inneritem">
				<span>Yesterday: </span><span><?=($report['s_yesterday']) ? $report['s_yesterday'] - $report['s_yesterday'] : '0'?> EGP</span>
			</div>

			<div class="inneritem">
				<span>Last month: </span><span><?=($report['s_month']) ? $report['s_month'] -$report['s_month'] : '0'?> EGP</span>
			</div>

			<div class="inneritem">
				<span>Last Year: </span><span><?=($report['s_year']) ? $report['s_year'] - $report['s_year']: '0'?> EGP</span>
			</div>
        </div>
    </div>
</div>
