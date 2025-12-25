<link rel="stylesheet" href="<?php echo base_url(); ?>/temp/default/css/select2.css" />
<script src="<?php echo base_url(); ?>/temp/default/js/multiple/select2.min.js"></script>
<style>
   .full-width {
      display: flex;
      justify-content: center;
   }

   .custom-container {
      width: 70%;
   }

   .tag-cats {
      align-items: flex-end;
      width: fit-content;
      margin-right: 10px;
      font-size: 15px;
      cursor: pointer;
      font-weight: 300;
      background: #e4e4e4 !important;
   }

   .is_activated {
      background: #2c91cb !important;
   }


   .select2-selection--multiple:before {
      content: "";
      position: absolute;
      right: 7px;
      top: 42%;
      border-top: 5px solid #888;
      border-left: 4px solid transparent;
      border-right: 4px solid transparent;
   }

   .select2-selection {
      border-radius: 4px;
      background: transparent;
   }

   .select2-search__field {
      background: transparent;
   }

   .select2-selection {
      background: transparent;
   }

   .smlinks {
      border: 1px solid #cacaca;
      width: 150px;
      height: 32px;
      line-height: 32px;
      margin: 0 5px;
      border-radius: 4px;
   }

   .smlinks:hover {
      border-color: #56bf85;
   }

   .smlinks a {
      padding: 0 !important
   }

   .order_wrap_list_items {
      width: 100%;
   }
</style>