<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ad;
use App\profile;
use Session;
use Auth; 
use App\Rlink;
use DB;


class adController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ads.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newAd['code'] = $request->code;
        $newAd['type'] =$request->adareaplacement;
        $newAd['page'] =$request->adpageplacement;
        if($request->adareaplacement=='sidebar' && $request->adpageplacement=='Chapters' || $request->adareaplacement=='sidebar' && $request->adpageplacement=='reading_page')
        {
            Session::flash('info','you can not place a sidebar ad in Chapters or reading pages');
            return redirect()->back();

        }
        else if($request->code ==null || $request->adareaplacement ==null || $request->adpageplacement ==null )
        {
            Session::flash('info','Did you miss something?');
            return redirect()->back();
        }
        ad::create($newAd);
        Session::flash('success','ad placed successfuly');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('admin.ads.index')
        ->with('ads',ad::all());
    }

    public function restrictAd(){
        $user_profile = profile::where('user_id',Auth::user()->id)->get();
        $user_profile = $user_profile[0];
        return view('admin.ads.restrict',compact('user_profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = ad::find($id);
        return view('admin.ads.edit')
        ->with('ad',$ad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newAd['code'] = $request->code;
        $newAd['type'] =$request->adareaplacement;
        $newAd['page'] =$request->adpageplacement;
        $newAd['status'] =$request->status;
        if($request->adareaplacement=='sidebar' && $request->adpageplacement=='Chapters' || $request->adareaplacement=='sidebar' && $request->adpageplacement=='reading_page')
        {
            Session::flash('info','you can not place a sidebar ad in Chapters or reading pages');
            return redirect()->back();

        }
        else if($request->code ==null || $request->adareaplacement ==null || $request->adpageplacement ==null )
        {
            Session::flash('info','Did you miss something?');
            return redirect()->back();
        }
        $update = ad::find($id);
        $update->update($newAd);
        Session::flash('success','ad updated successfuly');
        return redirect()->back();
    }

    public function activate($id)
    {
        $activate = ad::find($id);
        $update['staus'] = $activate->status =1;
        $activate->update($update);
        Session::flash('success','ad activated successfuly');
        return redirect()->back();
    }

    public function deactivate($id)
    {
        $activate = ad::find($id);
        $update['staus'] = $activate->status =0;
        $activate->update($update);
        Session::flash('success','ad Deactivated successfuly');
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $update = ad::find($id);
        $update->delete();
        Session::flash('success','ad deleted successfuly');
        return redirect()->back();
    }
    
    public function addNewstrict(Request $request){
        if(strlen($request->paste_link)<3){
            Session::flash('info','Please paste a link to add restriction !!');
            return redirect()->back();
        }else{
            DB::table('rlinks')->insert(
                ['link' => $request->paste_link, 'status' => 0]
            );
            Session::flash('success','Restriction link added !!');
            return redirect()->back();
        }
        
    }
    
    public function addNewstrictKey(Request $request){
        if(strlen($request->keyword)<1){
            Session::flash('info','Please write a keyword to add restriction !!');
            return redirect()->back();
        }else{
            DB::table('rkeywords')->insert(
                ['keyword' => $request->keyword, 'status' => 0]
            );
            Session::flash('success','Restriction keyword added !!');
            return redirect()->back();
        }
    }
    
    public function viewRlinks(){
        $user_profile = profile::where('user_id',Auth::user()->id)->get();
        $user_profile = $user_profile[0];
        $rlinks = DB::table('rlinks')->orderByRaw('id DESC')->get();
        // return $rlinks;
        return view('admin.ads.rLinks',compact('user_profile','rlinks'));
    }
    
    public function activaterLink($id){
        if(!is_null($id)){
            DB::table('rlinks')
            ->where('id', $id)
            ->update(['status' => 1]);
            Session::flash('success','Link updated !!');
            return redirect()->back();
        }
        Session::flash('info','Try Again later !!');
        return redirect()->back();
    }
    public function deactivaterLink($id){
        if(!is_null($id)){
            DB::table('rlinks')
            ->where('id', $id)
            ->update(['status' => 0]);
            Session::flash('success','Link updated !!');
            return redirect()->back();
        }
        Session::flash('info','Try Again later !!');
        return redirect()->back();
    }
    public function deleterLink($id){
        if(!is_null($id)){
            DB::table('rlinks')
            ->where('id', $id)
            ->delete();
            Session::flash('success','Link Deleted !!');
            return redirect()->back();
        }
        Session::flash('info','Try Again later !!');
        return redirect()->back();
    }
    
    public function viewRkeywords(){
        $user_profile = profile::where('user_id',Auth::user()->id)->get();
        $user_profile = $user_profile[0];
        $rkeywords = DB::table('rkeywords')->orderByRaw('id DESC')->get();
        // return $rlinks;
        return view('admin.ads.rKeywords',compact('user_profile','rkeywords'));
    }
    
    public function activaterkey($id){
        if(!is_null($id)){
            DB::table('rkeywords')
            ->where('id', $id)
            ->update(['status' => 1]);
            Session::flash('success','Keyword Updated !!');
            return redirect()->back();
        }
        Session::flash('info','Try Again later !!');
        return redirect()->back();
    }
    
    public function deactivaterkey($id){
        if(!is_null($id)){
            DB::table('rkeywords')
            ->where('id', $id)
            ->update(['status' => 0]);
            Session::flash('success','Keyword Updated !!');
            return redirect()->back();
        }
        Session::flash('info','Try Again later !!');
        return redirect()->back();
    }
    
    public function deleterkey($id){
        if(!is_null($id)){
            DB::table('rkeywords')
            ->where('id', $id)
            ->delete();
            Session::flash('success','Keyword Deleted !!');
            return redirect()->back();
        }
        Session::flash('info','Try Again later !!');
        return redirect()->back();
    }
}


























