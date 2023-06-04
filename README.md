# Wakatime Parser - PHP

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

This project provides analysis based on your WakaTime data.
It calculates the total time spent on different categories, languages, and projects, providing valuable (and free!) insights into your coding habits.

## Features

- **Time Tracking Analysis:** Gain a comprehensive overview of your time spent on coding projects.
- **Total Time Tracked:** Calculate the total time tracked in days, hours, and minutes.
- **Time Tracked by Category:** Analyze the distribution of time across different coding categories.
- **Time Tracked by Language:** Understand the amount of time spent on various programming languages.
- **Time Tracked by Project:** Identify the time dedicated to individual coding projects.


## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Installation

1. Clone the repository:
   ```shell
   git clone https://github.com/DevinNorgarb/wakatime-parser.git
   ```

2. Navigate to the project directory:
   ```shell
   cd wakatime-parser
   ```

3. Install dependencies:
   ```shell
   composer install
   ```

## Usage

1. Ensure you have a valid WakaTime data file in JSON format.
2. Run the PHP script with the following command, providing the JSON file as a command-line argument:
   ```shell
   php parse.php your_wakatime_data.json
   ```
   Replace `your_wakatime_data.json` with the appropriate WakaTime data file.

3. Review the generated output, including the total time tracked, time behind the PC, time tracked by category, language, and project.

## Contributing

Contributions are welcome! Follow these steps to contribute:

1. Fork the repository.
2. Create a new branch: `git checkout -b feature/your-feature-name`
3. Commit your changes: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature/your-feature-name`
5. Submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).

## Contact

For any inquiries or feedback, please contact:

Your Name
- Email: dnorgarb@gmail.com
- GitHub: [DevinNorgarb](https://github.com/DevinNorgarb)
```
