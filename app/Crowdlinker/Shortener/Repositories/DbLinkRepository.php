<?php  namespace Crowdlinker\Shortener\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use ShortLink;
class DbLinkRepository implements LinkRepositoryInterface
{

    public function create(array $data)
    {
        return ShortLink::create($data);
    }

    public function createApi($url,$hash,$pagetitle,$provider,$uid)
    {
        $shortlink = new ShortLink;
        $shortlink->url = $url;
        $shortlink->hash = $hash;
        $shortlink->pagetitle = $pagetitle;
        $shortlink->domainprovider = $provider;
        $shortlink->user_id = $uid;
        $shortlink->save();
    }

    public function byHash($hash)
    {
        return ShortLink::whereHash($hash)->first();
    }

    public function byUrl($url)
    {
        return ShortLink::whereUrl($url)->first();
    }

    public function byUser($id)
    {
        $data = ShortLink::where('user_id','=',$id)->remember(10)->get();
        $links = [];
        foreach($data as $value)
        {
            $created_at = Carbon::createFromTimeStamp(strtotime($value->created_at));
            $links[] =
            [
                'id' => $value->id,
                'link' => 'http://crdln.kr/'.$value['hash'],
                'pagetitle' => $value->pagetitle,
                'provider' => $value->domainprovider,
                'clicks' => $value->clicks,
                'created_at' => $created_at->toFormattedDateString()
            ];
        }
        return $links;
    }

    /**
     * Increase click count on view
     * @param $hash
     * @return mixed|void
     */
    public function increment($hash)
    {
        $shortlink = ShortLink::where('hash','=',$hash)->first();
        $shortlink->increment('clicks');
        $shortlink->save();
    }

}