package com.silverwing.zoobiz.network;

import com.silverwing.zoobiz.networkResponseModel.AllMembersResponse;
import com.silverwing.zoobiz.networkResponseModel.AreaResponse;
import com.silverwing.zoobiz.networkResponseModel.BillingDetailsResponse;
import com.silverwing.zoobiz.networkResponseModel.BlockedMemberResponse;
import com.silverwing.zoobiz.networkResponseModel.CardResponse;
import com.silverwing.zoobiz.networkResponseModel.CategoryResponse;
import com.silverwing.zoobiz.networkResponseModel.ChatRecentListResponse;
import com.silverwing.zoobiz.networkResponseModel.ChatResponse;
import com.silverwing.zoobiz.networkResponseModel.CircularsResponse;
import com.silverwing.zoobiz.networkResponseModel.CityResponse;
import com.silverwing.zoobiz.networkResponseModel.CityStateFilterResponse;
import com.silverwing.zoobiz.networkResponseModel.ClassifiedCategoryResponse;
import com.silverwing.zoobiz.networkResponseModel.ClassifiedResponse;
import com.silverwing.zoobiz.networkResponseModel.CllassifiedSubCategoriesResponse;
import com.silverwing.zoobiz.networkResponseModel.CommentResponce;
import com.silverwing.zoobiz.networkResponseModel.CommonResponse;
import com.silverwing.zoobiz.networkResponseModel.CompanyAddressResponse;
import com.silverwing.zoobiz.networkResponseModel.ProfileAndLogoResponse;
import com.silverwing.zoobiz.networkResponseModel.CountryResponse;
import com.silverwing.zoobiz.networkResponseModel.EmojiResponse;
import com.silverwing.zoobiz.networkResponseModel.FavouriteMemberResponse;
import com.silverwing.zoobiz.networkResponseModel.FilterCityResponse;
import com.silverwing.zoobiz.networkResponseModel.FollowersFollowingResponse;
import com.silverwing.zoobiz.networkResponseModel.GeoTagResponse;
import com.silverwing.zoobiz.networkResponseModel.LoginResponse;
import com.silverwing.zoobiz.networkResponseModel.MeetUpResponse;
import com.silverwing.zoobiz.networkResponseModel.MemberPlanListResponse;
import com.silverwing.zoobiz.networkResponseModel.MyActivityResponse;
import com.silverwing.zoobiz.networkResponseModel.NewsFeedResponce;
import com.silverwing.zoobiz.networkResponseModel.NotificationResponse;
import com.silverwing.zoobiz.networkResponseModel.ProfessionalDetailsResponse;
import com.silverwing.zoobiz.networkResponseModel.ProfileResponse;
import com.silverwing.zoobiz.networkResponseModel.PromitionEventListResponse;
import com.silverwing.zoobiz.networkResponseModel.RegisterCategoryResponse;
import com.silverwing.zoobiz.networkResponseModel.StateResponse;
import com.silverwing.zoobiz.networkResponseModel.SubCategoryResponse;
import com.silverwing.zoobiz.networkResponseModel.TempUserRegisterResponse;
import com.silverwing.zoobiz.networkResponseModel.UserTagListResponse;
import com.silverwing.zoobiz.networkResponseModel.ViewOtherMemberProfileResponse;
import com.silverwing.zoobiz.networkResponseModel.ZooBizContactUsResponse;
import com.silverwing.zoobiz.networkResponseModel.centerImageDetailsResponse;
import com.silverwing.zoobiz.networkResponseModel.dashboard.DashboardResponse;

import java.util.List;

import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;
import rx.Single;

public interface RestCall {

    @FormUrlEncoded
    @POST("get_dashboard_data_controller.php")
    Single<DashboardResponse> dashboardData(
            @Field("dashboardData") String dashboardData,
            @Field("user_id") String user_id,
            @Field("user_mobile") String user_mobile,
            @Field("version_code") String version_code,
            @Field("brand") String brand,
            @Field("model") String model,
            @Field("device") String device,
            @Field("user_token") String fcm_token);

    @FormUrlEncoded
    @POST("settings_controller.php")
    Single<CommonResponse> changeMobilePrivacy(
            @Field("changeMobilePrivacy") String changeMobilePrivacy,
            @Field("user_id") String user_id,
            @Field("public_mobile") String public_mobile);

    @FormUrlEncoded
    @POST("settings_controller.php")
    Single<CommonResponse> changeWahtasappPrivacy(
            @Field("changeWahtasappPrivacy") String changeWahtasappPrivacy,
            @Field("user_id") String user_id,
            @Field("whatsapp_privacy") String whatsapp_privacy);

    @FormUrlEncoded
    @POST("settings_controller.php")
    Single<CommonResponse> changeEmailIdPrivacy(
            @Field("changeEmailIdPrivacy") String changeEmailIdPrivacy,
            @Field("user_id") String user_id,
            @Field("email_privacy") String email_privacy);

    @FormUrlEncoded
    @POST("settings_controller.php")
    Single<CommonResponse> cllassifiedMuteStatus(
            @Field("cllassifiedMuteStatus") String cllassifiedMuteStatus,
            @Field("user_id") String user_id,
            @Field("cllassified_mute") String cllassified_mute);

    @FormUrlEncoded
    @POST("member_controller.php")
    Single<BlockedMemberResponse> getMyBlockedMember(
            @Field("getMyBlockedMember") String getMyBlockedMember,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("member_controller.php")
    Single<CommonResponse> blockUnUser(
            @Field("blockUnUser") String blockUnUser,
            @Field("user_id") String user_id,
            @Field("my_id") String my_id);

    @FormUrlEncoded
    @POST("member_controller.php")
    Single<CommonResponse> blockUser(
            @Field("blockUser") String blockUser,
            @Field("user_id") String user_id,
            @Field("my_id") String my_id);

    @FormUrlEncoded
    @POST("circularsController.php")
    Single<CircularsResponse> getCircularsList(
            @Field("getCirculars") String getCirculars,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("business_promition_controller.php")
    Single<PromitionEventListResponse> getPromotionEventData(
            @Field("getEventData") String getEventData,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("business_promition_controller.php")
    Single<centerImageDetailsResponse> getCenterImages(
            @Field("getCenterImages") String getCenterImages,
            @Field("promotion_id") String promotion_id,
            @Field("promotion_frame_id") String promotion_frame_id);

    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<NewsFeedResponce> getMyFeed(@Field("getMyFeed") String getMyFeed,
                                       @Field("user_id") String user_id,
                                       @Field("my_id") String my_id, //for comment
                                       @Field("limit_feed") int limit,
                                       @Field("pos1") int pos);

    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<NewsFeedResponce> getNewsFeed(@Field("getFeed") String getFeed,
                                         @Field("user_id") String user_id,
                                         @Field("timeline_id") String timelineId,
                                         @Field("limit_feed") int limit,
                                         @Field("pos1") int pos);

    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<CommentResponce> getComments(@Field("getComments") String getComments,
                                        @Field("timeline_id") String timeline_id);


    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<CommentResponce> commentFeed(@Field("commentFeed") String commentFeed,
                                        @Field("timeline_id") String feed_id,
                                        @Field("parent_comments_id") String parent_comments_id,
                                        @Field("user_id") String user_id,
                                        @Field("user_name") String user_name,
                                        @Field("msg") String msg);

    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<CommonResponse> deleteCommentFeed(@Field("deleteComment") String deleteComment,
                                             @Field("comments_id") String comments_id,
                                             @Field("user_id") String user_id);


    @FormUrlEncoded
    @POST("register_controller.php")
    Single<CityResponse> getCityForRegister(@Field("get_cities") String get_cities);

    @FormUrlEncoded
    @POST("registration_controller.php")
    Single<MemberPlanListResponse> getMembersPlan(
            @Field("getPackage") String getPackage);


    @FormUrlEncodedget_cities
    @POST("emoji_response.json")
    Single<EmojiResponse> getEmoji(
            @Field("getEmoji") String tag);

    @FormUrlEncoded
    @POST("check_coupon_validity.php")
    Single<CommonResponse> getValidCoupon(
            @Field("couponCodeValidity") String couponCodeValidity,
            @Field("coupon_code") String coupon_code);

    @FormUrlEncoded
    @POST("register_controller.php")
    Single<TempUserRegisterResponse> NewUserRegisterTemp(@Field("user_register_temp") String user_register_temp,
                                                         @Field("user_name") String user_first_name,
                                                         @Field("userMobile") String userMobile,
                                                         @Field("user_email") String user_email,
                                                         @Field("city_id") String city_id,
                                                         @Field("plan_id") String plan_id,
                                                         @Field("refer_type") String refer_type,
                                                         @Field("refer_friend_name") String refer_friend_name,
                                                         @Field("refer_friend_no") String refer_friend_no,
                                                         @Field("refer_remark") String refer_remark,
                                                         @Field("coupon_code") String coupon_code,
                                                         @Field("apply_coupon") boolean apply_coupon,
                                                         @Field("device") String device);

    @FormUrlEncoded
    @POST("common_controller.php")
    Single<LoginResponse> getUserProfile(@Field("get_profile_data") String get_profile_data,
                                         @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("register_controller.php")
    Single<CommonResponse> registerUser(@Field("user_register") String user_register,
                                        @Field("user_name") String user_last_name,
                                        @Field("userMobile") String userMobile,
                                        @Field("user_email") String user_email,
                                        @Field("plan_id") String plan_id,
                                        @Field("plan_with_gst_amount") String planwithGstAmount,
                                        @Field("city_id") String city_id,
                                        @Field("razorpay_payment_id") String razorpay_payment_id,
                                        @Field("razorpay_order_id") String razorpay_order_id,
                                        @Field("razorpay_signature") String razorpay_signature,
                                        @Field("refer_type") String refer_type,
                                        @Field("refer_friend_name") String refer_friend_name,
                                        @Field("refer_friend_no") String refer_friend_no,
                                        @Field("refer_remark") String refer_remark,
                                        @Field("coupon_code") String coupon_code,
                                        @Field("apply_coupon") boolean apply_coupon,
                                        @Field("device") String device);

    @FormUrlEncoded
    @POST("otp_controller.php")
    Single<CommonResponse> doLogin(
            @Field("user_login") String user_login,
            @Field("country_code") String country_code,
            @Field("user_mobile") String user_mobile);


    @FormUrlEncoded
    @POST("otp_controller.php")
    Single<LoginResponse> verifyOTP(
            @Field("user_verify") String user_verify,
            @Field("user_mobile") String user_mobile,
            @Field("otp") String otp,
            @Field("user_token") String user_token,
            @Field("device") String device,
            @Field("phone_model") String phone_model,
            @Field("phone_brand") String phone_brand);

    @FormUrlEncoded
    @POST("otp_controller.php")
    Single<CommonResponse> userLogout(
            @Field("user_logout") String user_logout,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<CommonResponse> addFeedLike(@Field("likeFeed") String likeFeed,
                                       @Field("timeline_id") String feed_id,
                                       @Field("user_id") String user_id,
                                       @Field("user_name") String user_name,
                                       @Field("like_status") String like_status);

    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<CommonResponse> saveTimeline(@Field("saveTimeline") String saveTimeline,
                                        @Field("timeline_id") String feed_id,
                                        @Field("user_id") String user_id,
                                        @Field("is_delete") boolean is_delete);


    @Multipart
    @POST("timeline_controller.php")
    Single<CommonResponse> addTimelinePost(@Part("addFeed") RequestBody addFeed,
                                           @Part("user_id") RequestBody user_id,
                                           @Part("timeline_id") RequestBody timeline_id,
                                           @Part("feed_type") RequestBody feed_type,
                                           @Part("timeline_text") RequestBody timeline_text,
                                           @Part("user_name") RequestBody user_name,
                                           @Part List<MultipartBody.Part> photos,
                                           @Part List<MultipartBody.Part> partsVideo);


    @Multipart
    @POST("register_controller.php")
    Single<LoginResponse> completeProfile(
            @Part("complete_profile") RequestBody complete_profile,
            @Part("user_id") RequestBody user_id,
            @Part("member_date_of_birth") RequestBody member_date_of_birth,
            @Part("whatsapp_number") RequestBody whatsapp_number,
            @Part("gender") RequestBody gender,
            @Part("company_name") RequestBody company_name,
            @Part("business_category_id") RequestBody business_category_id,
            @Part("business_sub_category_id") RequestBody business_sub_category_id,
            @Part("designation") RequestBody designation,
            @Part("company_website") RequestBody company_website,
            @Part("adress") RequestBody adress,
            @Part("area_id") RequestBody area_id,
            @Part("city_id") RequestBody city_id,
            @Part("state_id") RequestBody state_id,
            @Part("country_id") RequestBody country_id,
            @Part("pincode") RequestBody pincode,
            @Part("latitude") RequestBody latitude,
            @Part("longitude") RequestBody longitude,
            @Part("gst_number") RequestBody gst_number,
            @Part MultipartBody.Part user_profile_pic);


    @FormUrlEncoded
    @POST("registration_controller.php")
    Single<RegisterCategoryResponse> getSubCategoryRegister(
            @Field("getSubCategoryRegister") String getSubCategoryRegister);

    @FormUrlEncoded
    @POST("company_address_controller.php")
    Single<CountryResponse> getCountries(@Field("get_countries") String get_countries,
                                         @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("company_address_controller.php")
    Single<StateResponse> getStates(@Field("get_states") String get_states,
                                    @Field("user_id") String user_id,
                                    @Field("country_id") String country_id
    );

    @FormUrlEncoded
    @POST("company_address_controller.php")
    Single<CityResponse> getCity(@Field("get_cities") String get_cities,
                                 @Field("user_id") String user_id,
                                 @Field("country_id") String country_id,
                                 @Field("state_id") String state_id);

    @FormUrlEncoded
    @POST("company_address_controller.php")
    Single<AreaResponse> getArea(@Field("get_area") String get_area,
                                 @Field("user_id") String user_id,
                                 @Field("country_id") String country_id,
                                 @Field("state_id") String state_id,
                                 @Field("city_id") String city_id);

    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<NewsFeedResponce> getSavedFeed(@Field("getSavedFeed") String getSavedFeed,
                                          @Field("user_id") String user_id,
                                          @Field("limit_feed") int limit,
                                          @Field("pos1") int pos);

    @Multipart
    @POST("user_controller.php")
    Single<ProfileResponse> changeProfile(
            @Part("setProfilePicture") RequestBody setProfilePicture,
            @Part("user_id") RequestBody user_id,
            @Part MultipartBody.Part user_profile_pic);
    @Multipart
    @POST("employment_details_controller.php")
    Single<ProfileAndLogoResponse> changeProfileAndLogo(
            @Part("edit_profile_and_logo") RequestBody edit_company_logo,
            @Part("user_id") RequestBody user_id,
            @Part MultipartBody.Part companyLogo,
            @Part MultipartBody.Part profilePicture);

    @FormUrlEncoded
    @POST("profesional_detail_controller.php")
    Single<ProfessionalDetailsResponse> getProfessionalInfo(
            @Field("get_professional_info") String get_professional_info,
            @Field("user_id") String user_id);

    @Multipart
    @POST("profesional_detail_controller.php")
    Single<CommonResponse> addProfessionalDetails(
            @Part("add_professional_info") RequestBody add_professional_info,
            @Part("employment_id") RequestBody employment_id,
            @Part("user_id") RequestBody user_id,
            @Part("user_full_name") RequestBody user_full_name,
            @Part("user_phone") RequestBody user_phone,
            @Part("user_email") RequestBody user_email,
            @Part("business_category_id") RequestBody business_category_id,
            @Part("business_sub_category_id") RequestBody business_sub_category_id,
            @Part("business_description") RequestBody business_description,
            @Part("company_name") RequestBody company_name,
            @Part("designation") RequestBody designation,
            @Part("company_website") RequestBody company_website,
            @Part("search_keyword") RequestBody search_keyword,
            @Part("products_servicess") RequestBody products_servicess,
            @Part("company_email") RequestBody company_email,
            @Part("company_contact_number") RequestBody company_contact_number,
            @Part("company_landline_number") RequestBody landline_number,
            @Part("is_company_logo") RequestBody is_company_logo,
            @Part MultipartBody.Part company_logo,
            @Part("company_logo_old") RequestBody company_logo_old);

    @Multipart
    @POST("employment_details_controller.php")
    Single<CommonResponse> addCompanyProfile(
            @Part("edit_company_profile") RequestBody edit_company_profile,
            @Part("employment_id") RequestBody employment_id,
            @Part("user_id") RequestBody user_id,
            @Part MultipartBody.Part company_profile);

    @Multipart
    @POST("employment_details_controller.php")
    Single<CommonResponse> addCompanyBrochure(
            @Part("edit_company_broucher") RequestBody edit_company_broucher,
            @Part("employment_id") RequestBody employment_id,
            @Part("user_id") RequestBody user_id,
            @Part MultipartBody.Part company_broucher);

    @FormUrlEncoded
    @POST("company_address_controller.php")
    Single<CompanyAddressResponse> getCompanyAddress(@Field("get_company_address") String get_company_address,
                                                     @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("company_address_controller.php")
    Single<CommonResponse> deleteAddress(@Field("delete_address") String delete_address,
                                         @Field("user_id") String user_id,
                                         @Field("adress_id") String adress_id);

    @FormUrlEncoded
    @POST("company_address_controller.php")
    Single<CommonResponse> addCompanyAddress(@Field("add_company_address") String add_company_address,
                                             @Field("adress_id") String adress_id,
                                             @Field("user_id") String user_id,
                                             @Field("adress") String adress,
                                             @Field("city_id") String city_id,
                                             @Field("state_id") String state_id,
                                             @Field("country_id") String country_id,
                                             @Field("area_id") String area_id,
                                             @Field("pincode") String pincode,
                                             @Field("latitude") String latitude,
                                             @Field("longitude") String longitude,
                                             @Field("adress_type") String adress_type);


    @FormUrlEncoded
    @POST("get_billing_details_controller.php")
    Single<BillingDetailsResponse> getBillingInfo(
            @Field("get_billing_info") String get_billing_info,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("get_billing_details_controller.php")
    Single<CommonResponse> addBillingInfo(
            @Field("add_billing_info") String add_billing_info,
            @Field("employment_id") String employment_id,
            @Field("user_id") String user_id,
            @Field("company_name") String company_name,
            @Field("billing_address") String company_address,
            @Field("company_website") String company_website,
            @Field("company_contact_number") String company_contact_number,
            @Field("gst_number") String gst_number,
            @Field("billing_pincode") String billing_pincode,
            @Field("bank_name") String bank_name,
            @Field("bank_account_number") String bank_account_number,
            @Field("ifsc_code") String ifsc_code,
            @Field("billing_contact_person") String billing_contact_person,
            @Field("billing_contact_person_name") String billing_contact_person_name);

    @FormUrlEncoded
    @POST("common_controller.php")
    Single<CommonResponse> updateSocialLink(
            @Field("edit_social_links") String edit_social_links,
            @Field("user_id") String user_id,
            @Field("facebook") String facebook,
            @Field("instagram") String instagram,
            @Field("linkedin") String linkedin,
            @Field("twitter") String twitter);

    @FormUrlEncoded
    @POST("common_controller.php")
    Single<CommonResponse> updateAboutInfo(
            @Field("edit_basic_info") String edit_basic_info,
            @Field("user_id") String user_id,
            @Field("user_name") String user_name,
            @Field("gender") String gender,
            @Field("member_date_of_birth") String member_date_of_birth,
            @Field("user_email") String user_email,
            @Field("user_mobile") String user_mobile,
            @Field("alt_mobile") String alt_mobile,
            @Field("whatsapp_number") String whatsapp_number,
            @Field("otp_verified") boolean otp_verified);

    @FormUrlEncoded
    @POST("otp_controller.php")
    Single<CommonResponse> userVerifyNew(
            @Field("user_verify_new") String user_verify_new,
            @Field("user_id") String user_id,
            @Field("otp") String otp,
            @Field("temp_mobile_number") String temp_mobile_number);


    @FormUrlEncoded
    @POST("member_controller.php")
    Single<AllMembersResponse> getAllMembers(
            @Field("getAllMembers") String getAllMembers,
            @Field("user_id") String user_id,
            @Field("business_category_id") String business_category_id,
            @Field("business_sub_category_id") String business_sub_category_id,
            @Field("city_id") String city_id,
            @Field("state_id") String state_id);


    @FormUrlEncoded
    @POST("member_controller.php")
    Single<UserTagListResponse> getUserTag(
            @Field("getUserTag") String getUserTag,
            @Field("user_id") String user_id);


    @FormUrlEncoded
    @POST("follow_controller.php")
    Single<FollowersFollowingResponse> getFollowing(
            @Field("getFollowing") String getFollowing,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("follow_controller.php")
    Single<FollowersFollowingResponse> getFollowers(
            @Field("getFollowers") String getFollowers,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("favorite_member_controller.php")
    Single<FavouriteMemberResponse> getFavoriteMembers(
            @Field("getFavoriteMembers") String getFavoriteMembers,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("data_filter_controller.php")
    Single<FilterCityResponse> get_filter_cities(
            @Field("get_active_cities") String get_active_cities,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("data_filter_controller.php")
    Single<AllMembersResponse> getMembersTagFilter(
            @Field("getMembersTagFilter") String getMembersTagFilter,
            @Field("user_id") String user_id,
            @Field("business_sub_category_id") String business_sub_category_id,
            @Field("city_id") String city_id,
            @Field("search_keyword") String search_keyword);


    @FormUrlEncoded
    @POST("data_filter_controller.php")
    Single<AllMembersResponse> getZooBizMembersFilter(
            @Field("getFilterAllMembers") String getFilterAllMembers,
            @Field("user_id") String user_id,
            @Field("business_category_id") String business_category_id,
            @Field("business_sub_category_id") String business_sub_category_id,
            @Field("zoobiz_id") String zoobiz_id,
            @Field("user_full_name") String user_full_name,
            @Field("user_email") String user_email,
            @Field("user_mobile") String user_mobile,
            @Field("company_name") String company_name,
            @Field("city_id") String city_id,
            @Field("pincode") String pincode,
            @Field("state_id") String state_id);


    @FormUrlEncoded
    @POST("geo_tag_controller.php")
    Single<GeoTagResponse> getGeoFilterMember(
            @Field("getFilterAllGeoMembers") String getFilterAllGeoMembers,
            @Field("user_id") String user_id,
            @Field("business_category_id") String business_category_id,
            @Field("business_sub_category_id") String business_sub_category_id,
            @Field("zoobiz_id") String zoobiz_id,
            @Field("user_full_name") String user_full_name,
            @Field("user_email") String user_email,
            @Field("user_mobile") String user_mobile,
            @Field("company_name") String company_name,
            @Field("pincode") String pincode,
            @Field("city_id") String city_id,
            @Field("state_id") String state_id,
            @Field("distance") String distance,
            @Field("add_latitude_filter") String add_latitude_filter,
            @Field("add_longitude_filter") String add_longitude_filter);


    @FormUrlEncoded
    @POST("data_filter_controller.php")
    Single<CityStateFilterResponse> getCombineCityStateFilter(
            @Field("getCombineCityState") String getCombineCityState,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("data_filter_controller.php")
    Single<RegisterCategoryResponse> getSubCategoryFilter(
            @Field("getSubCategoryFilter") String getSubCategoryFilter);


    @FormUrlEncoded
    @POST("common_controller.php")
    Single<ViewOtherMemberProfileResponse> getOtherMemberDetails(
            @Field("get_other_member_details") String get_other_member_details,
            @Field("user_id") String user_id,
            @Field("member_id") String member_id,
            @Field("flag") String flag);


    @FormUrlEncoded
    @POST("zoobiz_contact_controller.php")
    Single<ZooBizContactUsResponse> getZoobizContact(
            @Field("zoobiz_contacts") String zoobiz_contacts,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("activity_controller.php")
    Single<MyActivityResponse> getActivity(
            @Field("getActivity") String getActivity,
            @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("activity_controller.php")
    Single<CommonResponse> deleteActivity(
            @Field("deleteAcitivity") String deleteAcitivity,
            @Field("user_id") String user_id);

    @Multipart
    @POST("zoobiz_contact_controller.php")
    Single<CommonResponse> send_feedback(@Part("send_feedback") RequestBody send_feedback,
                                         @Part("name") RequestBody name,
                                         @Part("email") RequestBody email,
                                         @Part("mobile") RequestBody mobile,
                                         @Part("subject") RequestBody subject,
                                         @Part("feedback_msg") RequestBody feed_msg,
                                         @Part MultipartBody.Part attachment);

    @FormUrlEncoded
    @POST("geo_tag_controller.php")
    Single<GeoTagResponse> getGeoMembersNew(
            @Field("getGeoMembersNew") String getGeoMembersNew,
            @Field("user_id") String user_id,
            @Field("city_id") String city_id,
            @Field("city_name") String city_name,
            @Field("user_latitude") String user_latitude,
            @Field("user_longitude") String user_longitude
    );


    @FormUrlEncoded
    @POST("favorite_member_controller.php")
    Single<CommonResponse> memberFavorite(
            @Field("memberFavorite") String memberFavorite,
            @Field("user_id") String user_id,
            @Field("member_id") String member_id,
            @Field("flag") String flag,
            @Field("is_delete") Boolean is_delete);


    @FormUrlEncoded
    @POST("follow_controller.php")
    Single<CommonResponse> addFollow(
            @Field("addFollow") String addFollow,
            @Field("user_id") String user_id,
            @Field("user_name") String user_name,
            @Field("follow_to") String follow_to);

    @FormUrlEncoded
    @POST("meeting_controller.php")
    Single<CommonResponse> addMeeting(@Field("addMeeting") String addMeeting,
                                      @Field("user_id") String user_id,
                                      @Field("member_id") String member_id,
                                      @Field("date") String date,
                                      @Field("time") String time,
                                      @Field("place") String place,
                                      @Field("agenda") String agenda);

    @FormUrlEncoded
    @POST("meeting_controller.php")
    Single<CommonResponse> rescheduleMeeting(@Field("rescheduleMeeting") String rescheduleMeeting,
                                             @Field("meeting_id") String meeting_id,
                                             @Field("user_id") String user_id,
                                             @Field("member_id") String member_id,
                                             @Field("user_name") String user_name,
                                             @Field("date") String date,
                                             @Field("time") String time,
                                             @Field("place") String place,
                                             @Field("agenda") String agenda);

    @FormUrlEncoded
    @POST("meeting_controller.php")
    Single<MeetUpResponse> getMyMeetings(@Field("getMyMeetings") String getMyMeetings,
                                         @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("meeting_controller.php")
    Single<CommonResponse> approveMeeting(@Field("approveMeeting") String approveMeeting,
                                          @Field("user_id") String user_id,
                                          @Field("meeting_id") String meeting_id,
                                          @Field("user_name") String user_name,
                                          @Field("reason") String reason);

    @FormUrlEncoded
    @POST("meeting_controller.php")
    Single<CommonResponse> rejectMeeting(@Field("rejectMeeting") String rejectMeeting,
                                         @Field("user_id") String user_id,
                                         @Field("meeting_id") String meeting_id,
                                         @Field("user_name") String user_name,
                                         @Field("reason") String reason);

    @FormUrlEncoded
    @POST("notification_controller.php")
    Single<NotificationResponse> getNotification(@Field("getOtherNotification") String getOtherNotification,
                                                 @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("notification_controller.php")
    Single<NotificationResponse> getMeetupNotification(@Field("getMeetupNotification") String getMeetupNotification,
                                                       @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("notification_controller.php")
    Single<CommonResponse> deleteUserNotification(@Field("DeleteUserNotification") String DeleteUserNotification,
                                                  @Field("user_notification_id") String user_notification_id);

    @FormUrlEncoded
    @POST("notification_controller.php")
    Single<CommonResponse> deleteUserNotificationAll(@Field("DeleteUserNotificationAll") String DeleteUserNotificationAll,
                                                     @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("notification_controller.php")
    Single<CommonResponse> deleteMeetUpNotificationAll(@Field("DeleteAllMeetupNotification") String DeleteUserNotificationAll,
                                                       @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("chat_controller.php")
    Single<ChatRecentListResponse> getRecentChatMember(
            @Field("getRecentChatMember") String getRecentChatMember,
            @Field("user_id") String user_id);


    @FormUrlEncoded
    @POST("chat_controller.php")
    Single<ChatResponse> getPrvChatNew(@Field("getPrvChatNew") String getPrvChatNew,
                                       @Field("user_id") String user_id,
                                       @Field("isRead") String isRead,
                                       @Field("userId") String userId);

    @FormUrlEncoded
    @POST("chat_controller.php")
    Single<CommonResponse> addChat(@Field("addChat") String addFeed,
                                   @Field("chat_id_reply") String chat_id_reply,
                                   @Field("msg_by") String msg_by,
                                   @Field("msg_for") String msg_for,
                                   @Field("msg_data") String msg_data,
                                   @Field("msgType") String msgType,
                                   @Field("location_lat_long") String location_lat_long,
                                   @Field("user_name") String user_name,
                                   @Field("user_profile") String user_profile,
                                   @Field("user_mobile") String user_mobile,
                                   @Field("public_mobile") Boolean public_mobile);


    @FormUrlEncoded
    @POST("chat_controller.php")
    Single<CommonResponse> chatBlock(@Field("chatBlock") String chatBlock,
                                     @Field("block_by") String block_by,
                                     @Field("block_for") String block_for);

    @FormUrlEncoded
    @POST("chat_controller.php")
    Single<CommonResponse> chatUnBlock(@Field("chatUnBlock") String chatUnBlock,
                                       @Field("block_by") String block_by,
                                       @Field("block_for") String block_for);

    @Multipart
    @POST("chat_controller.php")
    Single<CommonResponse> addChatMultiMedia(@Part("addChatWithDoc") RequestBody addChat,
                                             @Part("chat_id_reply") RequestBody chat_id_reply,
                                             @Part("msg_by") RequestBody msg_by,
                                             @Part("msg_for") RequestBody msg_for,
                                             @Part("msg_data[]") List<RequestBody> msg_data,
                                             @Part("msgType") RequestBody msgType,
                                             @Part("location_lat_long") RequestBody location_lat_long,
                                             @Part("user_name") RequestBody user_name,
                                             @Part("user_profile") RequestBody user_profile,
                                             @Part("user_mobile") RequestBody user_mobile,
                                             @Part("public_mobile") RequestBody public_mobile,
                                             @Part("file_duration") RequestBody file_duration,
                                             @Part List<MultipartBody.Part> chat_doc);

    @FormUrlEncoded
    @POST("chat_controller.php")
    Single<CommonResponse> deleteChatMulti(@Field("deleteChatMulti") String deleteChatMulti,
                                           @Field("user_id") String user_id,
                                           @Field("chat_id") String chat_id);

    @FormUrlEncoded
    @POST("member_controller.php")
    Single<CategoryResponse> getCategory(
            @Field("getCategory") String getCategory,
            @Field("user_id") String user_id);


    @FormUrlEncoded
    @POST("member_controller.php")
    Single<SubCategoryResponse> getSubCategory(
            @Field("getSubCategory") String getSubCategory,
            @Field("business_category_id") String business_category_id);

    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<ClassifiedResponse> GetClassfiedDetails(
            @Field("getCllassifiedDetails") String getCllassifiedDetails,
            @Field("user_id") String user_id,
            @Field("cllassified_id") String cllassified_id);

    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<ClassifiedCategoryResponse>
    getClassifiedCat(@Field("getCllassifiedCategories") String getCllassifiedCategories,
                     @Field("city_id") String city_id);


    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<CommonResponse> AddCllassifiedComment(
            @Field("addCllassifiedComment") String addCllassifiedComment,
            @Field("user_id") String user_id,
            @Field("user_name") String user_name,
            @Field("cllassified_id") String cllassified_id,
            @Field("comment_messaage") String comment_messaage);


    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<ClassifiedResponse> GetClassfiedList(
            @Field("getCllassified") String getCllassified,
            @Field("user_id") String user_id,
            @Field("business_category_id") String business_category_id,
            @Field("business_sub_category_id") String business_sub_category_id,
            @Field("state_id") String state_id,
            @Field("city_id") String city_id);

    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<CommonResponse> DeleteClassified(
            @Field("deleteCllassified") String deleteCllassified,
            @Field("user_id") String user_id,
            @Field("cllassified_id") String cllassified_id);

    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<CllassifiedSubCategoriesResponse> getCllassifiedSubCategories(@Field("getCllassifiedSubCategories") String getCllassifiedSubCategories,
                                                                         @Field("business_category_id") String business_category_id,
                                                                         @Field("city_id") String city_id);


    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<CommonResponse> deleteClassifiedComment(
            @Field("deleteComment") String deleteComment,
            @Field("user_id") String user_id,
            @Field("comment_id") String comment_id);

    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<CommonResponse> MuteUnmuteComment(
            @Field("addMute") String addMute,
            @Field("user_id") String user_id,
            @Field("cllassified_id") String cllassified_id,
            @Field("mute_type") String mute_type);

    @FormUrlEncoded
    @POST("cllassifiedController.php")
    Single<CommonResponse> AddReplyComment(
            @Field("addReplyComment") String addReplyComment,
            @Field("user_id") String user_id,
            @Field("user_name") String user_name,
            @Field("cllassified_id") String cllassified_id,
            @Field("comment_messaage") String comment_messaage,
            @Field("comment_id") String comment_id);

    @Multipart
    @POST("cllassifiedController.php")
    Single<CommonResponse> addCllassified(
            @Part("addCllassified") RequestBody addCllassified,
            @Part("business_category_id") RequestBody business_category_id,
            @Part("business_sub_category_id") RequestBody business_sub_category_id,
            @Part("state_id") RequestBody state_id,
            @Part("city_id") RequestBody city_id,
            @Part("user_id") RequestBody user_id,
            @Part("user_name") RequestBody user_name,
            @Part("cllassified_title") RequestBody cllassified_title,
            @Part("cllassified_description") RequestBody cllassified_description,
            @Part MultipartBody.Part cllassified_photo,
            @Part MultipartBody.Part cllassified_file);

    @FormUrlEncoded
    @POST("visiting_card_controller.php")
    Single<CardResponse> getCardsResponse(
            @Field("getCard") String getCard,
            @Field("society_id") String socifety_id);


    @FormUrlEncoded
    @POST("timeline_controller.php")
    Single<CommonResponse> deleteFeed(@Field("deleteFeed") String deleteFeed,
                                      @Field("timeline_id") String timeline_id,
                                      @Field("user_id") String user_id);

    @FormUrlEncoded
    @POST("common_controller.php")
    Single<CommonResponse> shareSeasonalGreet(@Field("shareSeasonalGreet") String shareSeasonalGreet,
                                      @Field("promotion_id") String promotion_id,
                                      @Field("user_id") String user_id);
}
