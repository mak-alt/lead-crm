require('./bootstrap')
import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link  } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import FlashMessages from '@/Shared/FlashMessages'
import route from "ziggy-js"
import CKEditor from '@ckeditor/ckeditor5-vue'

const app_name = 'TutorGem';

function asset(path){
    var base_path = window._asset || '';
    return base_path + path;
}

function injectScripts(path){
  var scriptElement=document.createElement('script');
  scriptElement.type = 'text/javascript';
  scriptElement.src = path;
  document.body.appendChild(scriptElement);
}

export default {
  asset,
  injectScripts,
}

const accepted_file_types_array = [
  'image/jpeg', 
  'image/gif', 
  'image/png', 
  'application/msword', 
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
  'application/vnd.ms-powerpoint', 
  'application/vnd.openxmlformats-officedocument.presentationml.presentation', 
  'application/vnd.ms-excel', 
  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
  'application/vnd.oasis.opendocument.presentation', 
  'application/vnd.oasis.opendocument.spreadsheet', 
  'application/vnd.oasis.opendocument.text', 
  'application/pdf', 
  'text/csv', 
  'text/plain', 
  'application/x-zip-compressed', 
  'application/zip', 
  'application/x-compressed', 
  'application/x-7z-compressed'
];

const accepted_file_types_global = 'image/jpeg, image/gif, image/png, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.oasis.opendocument.presentation, application/vnd.oasis.opendocument.spreadsheet, application/vnd.oasis.opendocument.text, application/pdf, text/csv, text/plain, application/x-zip-compressed, application/zip, application/x-compressed, application/x-7z-compressed'
const max_file_size = 52428800;

InertiaProgress.init()
createInertiaApp({
  resolve: (name) => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    const myApp = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(CKEditor)
      .component('Head', Head)
      .component('Link', Link)
      .component('FlashMessages', FlashMessages)
      .mixin(
        { 
          methods: {
            route,
            asset,
            injectScripts 
          } 
        }
      )
      myApp.config.globalProperties.accepted_file_types_array = accepted_file_types_array;
      myApp.config.globalProperties.accepted_file_types_global = accepted_file_types_global;
      myApp.config.globalProperties.max_file_size = max_file_size;
      myApp.config.globalProperties.app_name = app_name;
      myApp.mount(el)
  },
});