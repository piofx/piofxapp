<x-dynamic-component :component="$componentName">

    <div class="bg-white p-5 rounded-lg mt-3">
        <h3 class="p-3 rounded-sm border bg-light">Global settings</h3>
        <form action="" class="bg-light p-5 mt-3 rounded-lg">
            <h4 class="mb-3">Maintenance</h4>
            <label>Maintenance Message</label>
            <input type="text" name="maintenance_message" class="form-control" placeholder="The website will be in maintenance from * to *">
            <div class="form-check form-switch mt-2" style="font-size: 1.3rem">
                <input class="form-check-input" type="checkbox" name="maintenance_mode">
                <label class="form-check-label">Maintenenace Mode</label>
            </div>

            <button type="submit" name="save" class="btn btn-dark mt-3">Save</button>
        </form>
    </div>

</x-dynamic-component>