<?php

namespace App\Http\Controllers;

use App\Repositories\AdminRepository;
use App\Repositories\CertificateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function __construct(
        protected AdminRepository $adminRepository,
        protected CertificateRepository $certificateRepository
    )
    {
    }

    public function auth(Request $request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = $this->adminRepository->getAdmin($request->username);
        if (!$admin){
            return back()->with('login_error', 1);
        }
        if (Hash::check($request->input('password'), $admin->password)) {
            session()->flush();
            session()->put('admin',1);
            session()->put('name',$admin->name);
            session()->put('id',$admin->id);
            session()->put('username',$admin->username);
            return redirect()->route('admin.home');
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function logout(){
        session()->flush();
        return redirect()->route('admin.login');
    }

    public function profile(){
        $user = $this->adminRepository->getAdmin(session()->get('username'));
        return view('admin.profile', ['user' => $user]);
    }

    public function update(Request $request){
        $request->validate([
            'password1' => 'required|string',
            'password2' => 'required|string',
        ]);
        if ($request->input('password1') != $request->input('password2')) return back()->with('password_error',1);
        $this->adminRepository->update_password($request->password1);
        return back()->with('success',1);
    }

    public function home(){
        $certificates = $this->certificateRepository->getCertificates();
        return view('admin.home', ['certificates' => $certificates]);
    }

    public function newCertificate(Request $request){
        $validated_data = $request->validate([
            'student_name' => 'required|string',
            'course_name' => 'required|string',
        ]);

        $certificate = $this->certificateRepository->create($validated_data);

        return redirect()->route('admin.certificate', ['id' => $certificate->id]);
    }

    public function upload_image(Request $request){
        $request->validate([
            'id' => 'required|numeric',
            'image' => 'required|file|mimes:jpg,png,jpeg'
        ]);

        $file = $request->file('image')->getClientOriginalExtension();
        $name = md5(microtime());
        $audio_name = "certificates/".$name.".".$file;
        $path = $request->file('image')->move('certificates/',$audio_name);
        $data['file_path'] = $audio_name;
        $data['status'] = 'active';

        $this->certificateRepository->update($request->id, $data);

        return redirect()->route('admin.home')->with('image',1);
    }


    public function certificate($id){
        $certificate = $this->certificateRepository->getCertificate($id);
        return view('admin.certificate', ['certificate' => $certificate]);
    }

    public function deleteCertificate($id)
    {
        // Sertifikatni bazadan topamiz
        $certificate = $this->certificateRepository->getCertificate($id);

        if (!$certificate) {
            return redirect()->route('admin.home')->with('error', 'Sertifikat topilmadi!');
        }

        // Faylni o‘chirish
        if (!empty($certificate->file_path) && file_exists(public_path($certificate->file_path))) {
            unlink(public_path($certificate->file_path));
        }

        // Sertifikatni bazadan o‘chirish
        $this->certificateRepository->delete($id);

        return redirect()->route('admin.home')->with('success', 'Sertifikat o‘chirildi!');
    }

    public function show_certificate($id){
        $certificate = $this->certificateRepository->getCertificate($id);
        $status = 0;
        if($certificate){
            $status = 1;
        }
        return view('show', ['certificate'=>$certificate, 'status' => $status]);
    }

    public function downloadCertificate($id)
    {
        // Sertifikatni bazadan topamiz
        $certificate = $this->certificateRepository->getCertificate($id);

        if (!$certificate) {
            return back()->with('error', 'Sertifikat topilmadi!');
        }

        // Faylni topamiz
        $filePath = public_path($certificate->file_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'Sertifikat topilmadi!');
        }

        // Sertifikat nomini yaratamiz
        $fileName = basename($certificate->file_path);

        // Faylni yuklab olishga jo‘natamiz
        return response()->download($filePath, $fileName);
    }

}
