CREATE TABLE library.sach (
    ma_sach INT auto_increment PRIMARY KEY,
    ten_sach VARCHAR(200) NOT NULL collate 'utf8mb4_unicode_ci',
    tac_gia VARCHAR(50) NOT NULL collate 'utf8mb4_unicode_ci',
    nam_xb INT NOT NULL,
    nha_xb VARCHAR(50) NOT NULL collate 'utf8mb4_unicode_ci',
    nha_cung_cap VARCHAR(50) NOT NULL collate 'utf8mb4_unicode_ci',
    the_loai VARCHAR(50) NOT NULL collate 'utf8mb4_unicode_ci',
    quoc_gia VARCHAR(50) NOT NULL,
    so_luong INT NOT NULL,
    mo_ta VARCHAR(60000) NOT NULL collate 'utf8mb4_unicode_ci',
    anh_bia mediumblob NOT NULL
);

CREATE TABLE library.theloai (
    ma_the_loai INT auto_increment PRIMARY KEY,
    ten_the_loai VARCHAR(50) NOT NULL collate 'utf8mb4_unicode_ci'
);

CREATE TABLE library.nguoidung (
    email VARCHAR(100) PRIMARY KEY,
    hoten VARCHAR(50) NOT NULL collate 'utf8mb4_unicode_ci',
    mat_khau VARCHAR(255) NOT NULL collate 'utf8mb4_unicode_ci'
);

CREATE TABLE library.muon_sach (
    ma_giao_dich INT auto_increment PRIMARY KEY,
    email VARCHAR(100),
    ma_sach INT,
    so_luong_sach_muon INT NOT NULL,
    Foreign Key (email) REFERENCES library.nguoidung(email) ON DELETE CASCADE ON UPDATE CASCADE,
    Foreign Key (ma_sach) REFERENCES library.sach(ma_sach) ON DELETE CASCADE
)