<div class="container mt-5">

    <div class="col-12">
        <div class="card mt-2">
            <div class="card-header">
                <b>API</b>
            </div>
            <div class="card-body">

                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control form-control-sm" placeholder="API key"
                                aria-label="API key" value="<?php echo $this->member->api_key; ?>" id="Api-Key">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary btn-sm" id="resetApikey">Regenerate
                                API-key</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#copy_button').click(function() {
            $('.chidden').show();
            var clipboardValue = $('#json_link')[0].href;
            var aux = document.createElement("input");
            aux.setAttribute("value", clipboardValue);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            $('.chidden').hide();
            $('.thongbao').text('Coppied !');
        });

        $('#resetApikey').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            ajurl = "<?php echo base_url('v2/profile/resetApi'); ?>";
            $.ajax({
                type: "POST",
                url: ajurl,
                data: 'resetApikey',
                success: function(apikey) {
                    $('#Api-Key').val(apikey);
                },
                error: ajaxErr
            });

        });

        function ajaxErr() {
            alert('Update Error!');
        }
    });
</script>
<style>
    h1 {
        font-size: 2rem;
    }

    h2 {
        font-size: 1.5rem;
    }

    h3 {
        font-size: 1.25rem;
    }

    .container {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px
    }
</style>
<div class="container">
    <h1 class="mb-4">API Documentation for Advertisers</h1>

    <h2>Overview</h2>

    <p>This API allows advertisers to post conversion or lead
        information to our network. To use the API, you need to include
        an API key in the URL as a GET parameter and adhere to the data
        format we require.
    </p>

    <h2>Endpoint URL</h2>

    <?php $aplink = base_url('api/adv/conversions?apikey=YOURAPIKEY'); ?>

    <pre class="bg-light p-3 rounded"><code><span class="badge bg-success">POST</span> <?php echo $aplink; ?></a></code></pre>

    <h2>Conversion/Lead Information</h2>

    <h3>Data Format</h3>

    <p>The data should be sent in JSON format with the following
        fields:
    </p>

    <ul>
        <li><code>click_id</code>: The click ID provided at the time of the click.</li>
        <li><code>commission</code>: The commission amount for the conversion.</li>
        <li><code>sale_amount</code>: The sale amount for the conversion.</li>
    </ul>

    <h3>Request Example</h3>
    <pre class="bg-light p-3 rounded">
        <code>
            {           
            "click_id": "12345",
            "commission": 50.00,
            "sale_amount": 500.00
            }
        </code>
    </pre>
    <h3>Response</h3>
    <p>If the request is successfully processed, the API will return an
        HTTP status code of 200 and a confirmation message.</p>

    <h3>Response Example</h3>
    <pre class="bg-light p-3 rounded">
        <code>
            {
                "status": "success",
                "message": "Conversion recorded successfully"
            }
        </code>
    </pre>

    <h2>Status Codes</h2>
    <ul>
        <li><code>200 OK</code>: The request was successful.</li>
        <li><code>400 Bad Request</code>: The request is invalid
            (missing or incorrectly formatted data).</li>
        <li><code>401 Unauthorized</code>: Access is denied (invalid API
            key).</li>
        <li><code>500 Internal Server Error</code>: System error.</li>
    </ul>

    <h2>Support Contact</h2>
    <p>If you encounter any issues while using the API, please contact us at <a
            href="mailto:support@wwaff.com">support@wwaff.com</a> or call +84-123-456-789.</p>
</div>