<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        // Simpan data kontak baru
        $contact = new Contact();
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->save();

        return response()->setJSON(['message' => 'Contact created successfully']);
    }

    public function update(Request $request, $id)
    {
        // Temukan kontak berdasarkan ID
        $contact = Contact::findOrFail($id);

        // Validasi data yang masuk
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        // Update data kontak
        $contact->update($request->all());

        return response()->setJSON(['message' => 'Contact updated successfully']);
    }

    public function show($id)
    {
        // Temukan kontak berdasarkan ID
        $contact = Contact::findOrFail($id);

        return response()->setJSON($contact);
    }

    public function search(Request $request)
    {
        // Cari kontak berdasarkan kriteria tertentu
        $contacts = Contact::where('first_name', 'like', '%' . $request->search . '%')
                            ->orWhere('last_name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('phone', 'like', '%' . $request->search . '%')
                            ->get();

        return response()->setJSON($contacts);
    }

    public function destroy($id)
    {
        // Hapus kontak berdasarkan ID
        Contact::findOrFail($id)->delete();

        return response()->setJSON(['message' => 'Contact deleted successfully']);
    }
}