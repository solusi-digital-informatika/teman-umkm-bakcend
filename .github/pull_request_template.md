# INFORMASI PR

- Branch: <!-- contoh: feat/auth -->
- Creator: <!-- @username -->

## 📋 Deskripsi

<!-- Jelaskan secara singkat apa yang diubah/ditambahkan pada PR ini -->

## 🔗 Related Issue / Task

Closes #

## 🧩 Jenis Perubahan

- [ ] 🆕 Fitur baru
- [ ] 🐛 Bug fix
- [ ] ♻️ Refactor (tidak mengubah fungsionalitas)
- [ ] 🎨 UI/UX
- [ ] 📝 Dokumentasi
- [ ] ⚙️ Perubahan konfigurasi / infrastruktur
- [ ] 🧪 Test

## 📦 Modul yang Terdampak

<!-- Centang modul yang terkait sesuai arsitektur produk (Bagian 17 PRD) -->

- [ ] Product Management
- [ ] Cost & HPP Calculator
- [ ] Smart Pricing (Pricing Engine)
- [ ] Sales Recording
- [ ] Profit Analysis (Profit Engine)
- [ ] Fund Allocation
- [ ] Profit Goal (Goal Engine)
- [ ] Business Health Score (Health Score Engine)
- [ ] Actionable Insight Engine
- [ ] Dashboard
- [ ] Autentikasi / User / Business
- [ ] Lainnya: \***\*\_\_\*\***

## 🧮 Perubahan pada Formula / Rule Bisnis

<!-- WAJIB diisi jika PR menyentuh HPP, Pricing, Profit, Goal, Health Score, atau Insight Engine -->
<!-- Jika tidak ada perubahan formula, tulis: Tidak ada -->

- Formula/rule sebelum:
- Formula/rule sesudah:
- Alasan perubahan:

## ✅ Checklist

- [ ] Kode sudah diuji secara lokal
- [ ] Tidak ada breaking change pada alur data Cost → HPP → Pricing → Sales → Profit → Goal → Health Score → Insight
- [ ] Perhitungan angka (HPP, margin, profit, skor) sudah diverifikasi dengan skenario manual
- [ ] Insight/rekomendasi yang dihasilkan sudah sesuai rule pada Bagian 8.10 PRD
- [ ] Dashboard tetap menampilkan maksimal 1 insight prioritas pada "Focus This Week"
- [ ] Tidak menambahkan fitur di luar cakupan MVP (P0) tanpa persetujuan (lihat Bagian 11 PRD)
- [ ] Sudah menambahkan/menyesuaikan unit test (jika berlaku)
- [ ] Sudah update dokumentasi terkait (jika berlaku)
- [ ] Tidak ada data sensitif/API key yang ter-commit

## 🖼️ Screenshot / Demo (jika ada perubahan UI)

<!-- Lampirkan screenshot before/after atau screen recording -->

## 🧪 Cara Testing

<!-- Langkah-langkah reviewer untuk mencoba perubahan ini -->

1.
2.
3.

## ⚠️ Catatan Tambahan

<!-- Risiko, dependency, atau hal lain yang perlu diperhatikan reviewer -->

## 📌 Isu Terkait

<!-- contoh: Closes #1, Fixes #67 -->
