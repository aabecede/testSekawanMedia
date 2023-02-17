APLIKASI MONITORING ASSET KENDARAAN
requiredment :
php7.3, laravel 8


1. Lakukan Clone Pada url github : https://github.com/aabecede/testSekawanMedia
2. jangan lupa pindahkan .env.example ke .env (copy saja)
3. jangan lupa composer update / install
4. lakukan migrate
5. akan terdapat 5 role : super-admin, admin, staf, kepala-cabang, kepala-region, tapi role yang akan digunakan berdasarkan mapping
super-admin dan admin -> is_admin,
6. silahkan lihat didatabase untuk melihat user loginnya: default password : 123456789


Penjelasan Menu :
Terdapat Menu Master dan Pemesanan.

Menu Master :
- Region
- Kantor
- Tambang
- Kendaraan
- Pegawai
- ![image](https://user-images.githubusercontent.com/42539269/219530798-c972379b-2a4b-4169-8421-a389ca01f7e9.png)

Menu Pemsanan :
- Pemesanan Kendaraan
- Jadwal Service
- Pengisian BBM
![image](https://user-images.githubusercontent.com/42539269/219530866-359b55f0-439b-4608-87e2-d9c83ef7b1ce.png)
