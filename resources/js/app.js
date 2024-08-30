import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import 'laravel-datatables-vite';

import select2 from 'select2';
select2();

// Now import daterangepicker after moment is exposed globally
import 'daterangepicker/daterangepicker.css';
import 'daterangepicker';

// jquery-toast-plugin
import 'jquery-toast-plugin';
import 'jquery-toast-plugin/dist/jquery.toast.min.css';