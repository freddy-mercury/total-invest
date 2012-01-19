Calculator = {
	now:0,
	Plan:null,
	amount:0,
	compounding:100,
	getResult:function (now, Plan, amount, compounding) {
		this.now = parseInt(now);
		this.Plan = Plan;
		this.amount = parseFloat(amount);
		this.compounding = parseInt(compounding);
		if (this.Plan === undefined) {
			return 'Invalid plan!';
		}
		if (!this.check()) {
			return 'Invalid amount!';
		}
		var result = 0;
		if (Plan.principal_back)
			result+= this.amount;
		if (Plan.percent_per == 'periodicity') {
			return parseFloat(result) + parseFloat(this.complexPercents());
		}
		return parseFloat(result) + parseFloat(this.simplePercents());
	},
	check:function () {
		return (this.amount >= parseFloat(this.Plan.min) && this.amount <= parseFloat(this.Plan.max));
	},
	isWorkingDay:function (timestamp) {
		var date = new Date(0);
		date.setSeconds(timestamp);
		var day = date.getDay();
		/* not (Saturday and Sunday) */
		return !( day == 0 || day == 6);
	},
	simplePercents:function () {
		var result = this.amount * parseFloat(this.Plan.percent) / 100;
		return parseFloat(result.toFixed(3));
	},
	complexPercents:function () {
		var iterations = this.Plan.term / this.Plan.periodicity;
		var timestamp = this.now;
		var working_days = 0;
		var result = 0;
		var out = 0;
		for (var i = 0; i < iterations; i++) {
			if (!this.Plan.monfri || this.isWorkingDay(timestamp)) {
				working_days++;
				result = parseFloat((this.amount * (1 + this.Plan.percent / 100)).toFixed(4));
				var profit = parseFloat(((result - this.amount)).toFixed(4));
				out += parseFloat((profit * (1 - this.compounding / 100)).toFixed(4));
				this.amount = parseFloat((this.amount + profit * this.compounding / 100).toFixed(4));
			}
			timestamp += this.Plan.periodicity;
		}
		return parseFloat(result + out).toFixed(3);
	}
}
