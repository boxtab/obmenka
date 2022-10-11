<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Model;

/**
 * Константы таблицы платьежных систем.
 *
 * Class PaymentSystemConstant
 * @package App\Models\Constants
 */
class PaymentSystemConstant extends Model
{
	const BITCOIN = 1;
	const ETHEREUM = 2;
	const LITECOIN = 3;
	const RIPPLE = 4;
	const TETHER = 5;
	const SBERBANK = 6;
	const PRIVAT = 7;
	const QIWI = 8;
	const YANDEX_MONEY = 9;
	const ADVANCED = 10;
	const PERFECT_MONEY = 11;
	const VISA_MASTERCARD_UAH = 12;
	const TINKOFF = 13;
	const ALPHA_BANK = 14;
	const CASH = 15;
	const BURSE = 24;
	const MONO = 25;
	const ADVRUB = 26;
	const ADVUSD = 27;
	const BCH = 28;
	const BTZ = 29;
	const DASH = 30;
	const ETC = 31;
	const ETH = 32;
	const LTC = 33;
	const PMUSD = 34;
	const TRX = 35;
	const XMR = 36;
	const XRP = 37;
	const ZEC = 38;
	const NEO = 39;
	const ENFINS = 40;
	const FOR4BILL = 41;
	const PAYEER = 42;
	const EUR = 43;
	const ADA = 44;
	const EXM = 45;
	const BTG = 46;
	const OMG = 47;
	const WMZ = 48;
	const WMR = 49;
	const ETH_B = 50;
	const SKRILL = 51;
	const BTS = 52;
	const BTK = 53;
	const USDK = 54;
	const USDO = 55;
	const BTC_LOCAL = 56;
	const BTC_BINANCE = 57;
	const BTC_SITE = 58;
	const USDT_BINANCE = 59;
	const USDT_SITE = 60;
	const VISA_MASTERCARD_RUB = 61;
}
