<?php
include_once(LIB_ROOT.'/plans/plan.class.php');
class Earnings {
	public function calculate() {
		$result = sql_query('select * from translines where user_id="'.Project::getInstance()->getCurUser()->id.'" and type="d" and status="1" and stamp<'.Project::getInstance()->getNow().'');
		if ($result) {
			while ($deposit = mysql_fetch_assoc($result))	{
				$plan = new Plan($deposit['plan_id']);
				$stamp = $deposit['stamp']+($plan->periodicy_value*$plan->periodicy);
				$earnings_count = $plan->term*86400/($plan->periodicy_value*$plan->periodicy);
				if ($plan->percent_per == 'term') {
					if (Project::getInstance()->getCurUser()->monitor == 1) {
						//������� �������� ������ %
						$plan->percent-=100;
					}
					//�������� �������� ����� � ����� �� ���-������
					$amount = round($deposit['amount']*($plan->percent/100/$earnings_count), 3);
				}
				elseif ($plan->percent_per == 'periodicity') {
					if (Project::getInstance()->getCurUser()->monitor == 1) {
						//
						$total_percent = $earnings_count*$plan->percent;
						//�������� �������� ����� - 100% � ����� �� ���-������
						$amount = round($deposit['amount']*($total_percent-100/100/$earnings_count), 3);
					}
					else {
						//����� �� �������
						$amount = round($deposit['amount']*($plan->percent/100), 3);
					}
				}
				for ($i=0; $i < $earnings_count; $i++) {
					$stamp_day = date('w', $stamp);
					//���� � ����� ������� ����� working_days, �� ���������� ������ � ��-��
					if (($plan->working_days && ($stamp_day == 0 || $stamp_day == 6)) && $plan->percent_per == 'term') {
						$earnings_count++;
					}
					if (!$plan->working_days || ($plan->working_days && ($stamp_day != 0 && $stamp_day != 6))) {
						sql_query('insert into translines values (0, "'.$deposit['id'].'", "'.Project::getInstance()->getCurUser()->id.'", "'.$plan->id.'", "e", "'.$amount.'", "'.$stamp.'", "1", "")');
					}
					$stamp+=($plan->periodicy_value*$plan->periodicy);
				}
				sql_query('update translines set status="2" where id="'.$deposit['id'].'"');
				/**
				 * ��������� ����� ��� �������
				 */
				if (Project::getInstance()->getCurUser()->monitor == 1) {
					sql_query('insert into translines values (0, "'.$deposit['id'].'", "'.Project::getInstance()->getCurUser()->id.'", "0", "b", "'.$deposit['amount'].'", "'.$stamp.'", "1", "")');
				}
			}
		}
	}
	private function bonusReferrals() {
		$user = new UserOld(Project::getInstance()->getCurUser()->id);
		$referrals = $user->getReferralList();
		
	}
}
