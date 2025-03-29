# Excel Template Export Feature

This feature allows you to export SCP Measurements data into a pre-designed Excel template that preserves formatting, calculations, and other data outside of the export area.

## How It Works

1. A template Excel file is used as the base. This template has pre-defined cells, formulas, and formatting.
2. When you click "Export to Template", your SCP Measurements data is inserted into specific cells in the template.
3. All existing calculations, charts, and formatting in the template are preserved.
4. The result is a professionally formatted Excel file with your data, ready for analysis or presentation.

## Setup

### Step 1: Create the Template

The system comes with a default template that you can customize. To create or recreate the default template:

```bash
php artisan app:create-scp-measurement-template
```

This creates a template at `storage/app/templates/scp_measurements_template.xlsx`.

### Step 2: Customize the Template (Optional)

1. Find the template at `storage/app/templates/scp_measurements_template.xlsx`
2. Open it in Excel and customize the formatting, add charts, formulas, etc.
3. **Important:** Keep rows 10 and onward free for data insertion
4. Save the file in the same location with the same name

### Step 3: Use the Export Feature

1. Go to the SCP Measurements page
2. Click the "Export to Template" button in the top-right corner
3. Wait for the background job to complete
4. A notification will appear with a download link when ready

## Technical Details

The export to template feature uses:

-   PHPSpreadsheet library for Excel manipulation
-   Laravel queue system for background processing
-   The original template from `storage/app/templates/scp_measurements_template.xlsx`
-   Data inserted starting from row 10

## Custom Template Format

If you're creating a custom template:

1. Data will be inserted in these columns starting at row 10:

    - Column A: Date & Time
    - Column B: Operator
    - Column C: Series Number
    - Column D: Product Name
    - Column E: Measurements

2. You can add calculations, charts, and other features anywhere else in the sheet

## Troubleshooting

If you encounter issues:

1. Ensure the queue worker is running (refer to the queue worker setup documentation)
2. Check if the template file exists at the correct location
3. If needed, recreate the template using the artisan command
