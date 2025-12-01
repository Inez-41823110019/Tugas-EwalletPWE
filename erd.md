# ERD eWallet Application

erDiagram
    USERS ||--|| WALLETS : punya
    WALLETS ||--o{ TOPUPS : menambahkan
    WALLETS ||--o{ EXPENSES : membuat
