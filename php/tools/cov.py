import re
from pathlib import Path


def update_recipe_ingredients(file_path: str):
    path = Path(file_path)

    if not path.exists():
        print(f"Error: The file '{file_path}' could not be found.")
        return

    # Read the full content of recipes.php
    content = path.read_text(encoding='utf-8')

    # Mapping of target problematic keys to their standardized compatible replacements
    replacements = {
        r"\['tinned_peaches'\]": "['peaches_canned']",
        r"\['minced_beef'\]": "['beef_mince']",
        r"\['plain_flour_white'\]": "['plain_flour']"
    }

    modified_content = content
    changes_made = 0

    # Apply substitutions using regex patterns
    for pattern, replacement in replacements.items():
        # Count occurrences before executing the replacement
        matches = re.findall(pattern, modified_content)
        if matches:
            count = len(matches)
            modified_content = re.sub(pattern, replacement, modified_content)
            print(
                f"Updated {count} occurrence(s) of key: {pattern.replace('\\', '')} -> {replacement}")
            changes_made += count

    if changes_made > 0:
        # Write the updated clean text string back to the PHP file
        path.write_text(modified_content, encoding='utf-8')
        print(
            f"\nSuccess: Completed {changes_made} structural ingredient update(s) in '{file_path}'.")
    else:
        print(
            "\nNo incorrect or incompatible ingredient array keys were found in the file.")


if __name__ == "__main__":
    # Point this directly to your local recipes.php file path location
    target_file = "recipes.php"
    update_recipe_ingredients(target_file)
