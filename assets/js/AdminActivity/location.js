import {Locationadmin} from './location_admin.js';

export class Location{

	loc_id;
	loc_name;
	address_line_1;
	address_line_2;
	country_id;
	state_id;
	city_id;
	pin_code;
	admin_id;
	locationadmin = new Locationadmin();
}